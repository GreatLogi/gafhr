<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\Approve;

use App\Http\Controllers\Controller;
use App\Models\GAFTOTRAVELRECORD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApproveController extends Controller
{
    public function Approve_Deployment()
    {
        $data = GAFTOTRAVELRECORD::where('status', '=', '1');
        $data->orderByRaw('DATEDIFF(departure_date, CURDATE())');
        return DataTables::of($data)
            ->addColumn('departuredays', function ($record) {
                $today = Carbon::now();
                if (($record->status == '0' || $record->status == '1') && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    if ($today->isSameDay($departureDate)) {
                        return 'Due to Depart';
                    } elseif ($today->isBefore($departureDate)) {
                        $daysLeft = $today->diffInDays($departureDate);
                        return '<span class="badge badge-primary mr-1">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="badge badge-danger">' . $daysPassed . ' Day(s) Passed</span>';
                    }
                } elseif ($record->status == '1' && $record->return_date) {
                    $returnDate = Carbon::parse($record->return_date);
                    $remainingDays = $today->diffInDays($returnDate, false);
                    if ($today->isAfter($returnDate)) {
                        return '<span class="badge badge-danger mr-1">' . abs($remainingDays) . ' Days Passed</span>';
                    } elseif ($today->isSameDay($returnDate)) {
                        return '<span class="badge badge-warning mr-1">Today is the Return Date</span>';
                    } else {
                        return '<span class="badge badge-primary mr-1">' . $remainingDays . ' Day(s) Left to Return</span>';
                    }
                }
                return '';
            })
            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })

            ->editColumn('status', function ($row) {
                switch ($row->status) {
                    case '1':
                        return '<span class="badge badge-primary mr-1">APPROVED</span>';
                    case '1':
                        return '<span class="badge badge-success mr-1">TRAVELED</span>';
                    case '5':
                        return '<span class="badge badge-secondary mr-1">RETURNED</span>';
                    case '6':
                        return '<span class="badge badge-secondary mr-1">REPATRIATED</span>';
                    default:
                        return '';
                }
            })
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
            })
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
                <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>';
            })
            ->addColumn('checkbox', function ($row) {
                if ($row->status == '1') {
                    return '<div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input approve-checkbox"
                                    data-record-id="' . $row->id . '"
                                    id="approve-checkbox-' . $row->id . '">
                                <label class="custom-control-label"
                                    for="approve-checkbox-' . $row->id . '"> </label>
                            </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['return_date', 'full_name', 'departuredays', 'checkbox', 'status', 'action'])
            ->make(true);
    }


    public function Approve_Deployment_first_user(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $today = Carbon::now();

        $query = GAFTOTRAVELRECORD::where('status', '=', '1');
        if ($startDate && $endDate) {
            $query->whereBetween('departure_date', [$startDate, $endDate]);
        }
        $query->orderByRaw('DATEDIFF(departure_date, CURDATE())');
        return DataTables::of($query)
            ->addColumn('departuredays', function ($record) use ($today) {
                if (($record->status == '0' || $record->status == '1') && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    if ($today->isSameDay($departureDate)) {
                        return 'Due to Depart';
                    } elseif ($today->isBefore($departureDate)) {
                        $daysLeft = $today->diffInDays($departureDate);
                        return '<span class="badge badge-primary mr-1">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="badge badge-danger">' . $daysPassed . ' Day(s) Passed</span>';
                    }
                } elseif ($record->status == '1' && $record->return_date) {
                    $returnDate = Carbon::parse($record->return_date);
                    $remainingDays = $today->diffInDays($returnDate, false);
                    if ($today->isAfter($returnDate)) {
                        return '<span class="badge badge-danger mr-1">' . abs($remainingDays) . ' Days Passed</span>';
                    } elseif ($today->isSameDay($returnDate)) {
                        return '<span class="badge badge-warning mr-1">Today is the Return Date</span>';
                    } else {
                        return '<span class="badge badge-primary mr-1">' . $remainingDays . ' Day(s) Left to Return</span>';
                    }
                }
                return '';
            })
            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
                    case '1':
                        return '<span class="badge badge-primary mr-1">APPROVED</span>';
                    case '2':
                        return '<span class="badge badge-success mr-1">TRAVELED</span>';
                    case '5':
                        return '<span class="badge badge-secondary mr-1">RETURNED</span>';
                    case '6':
                        return '<span class="badge badge-secondary mr-1">REPATRIATED</span>';
                    default:
                        return '';
                }
            })
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
            })
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>';
            })
            ->addColumn('checkbox', function ($row) {
                if ($row->status == '1') {
                    return '<div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input approve-checkbox"
                                    data-record-id="' . $row->id . '"
                                    id="approve-checkbox-' . $row->id . '">
                                <label class="custom-control-label"
                                    for="approve-checkbox-' . $row->id . '"> </label>
                            </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['return_date', 'full_name', 'departuredays', 'checkbox', 'status', 'action'])
            ->make(true);
    }

}
