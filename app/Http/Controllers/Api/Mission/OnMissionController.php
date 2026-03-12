<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\Mission;

use App\Http\Controllers\Controller;
use App\Models\GAFTOTRAVELRECORD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OnMissionController extends Controller
{

    public function repatriation_remarks(Request $request, $uuid)
    {
        $data = GAFTOTRAVELRECORD::where('uuid', $uuid)->first();
        if ($data) {
            $data->repatriation_remarks = $request->repatriation_remarks;
            $data->status = 6;
            $data->return_date = today();
            $data->save();
            $notification = [
                'message' => 'Repatriated Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('view-record')->with($notification);
        }
    }

    public function OnMission()
    {
        $data = GAFTOTRAVELRECORD::where('status', '=', '2')->whereDate('departure_date', '<=', now());
        $data->orderByRaw('DATEDIFF(return_date, CURDATE())');
        return DataTables::of($data)
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
                <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>';
            })
            ->addColumn('action_second', function ($row) {
                if ($row->status == '2') {
                    return '<div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('course.arriving.personnel', $row->id) . '" id="ReturnedBtn">Return</a>
                                <a class="dropdown-item rapatriation" href="' . route('repatriation-edit', $row->uuid) . '">Rapatriation</a>

                            </div>
                        </div>';
                } else {
                    return '';
                }
            })

            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
            })

            ->addColumn('return_status', function ($record) {
                $today = Carbon::now();
                if (($record->status == '0' || $record->status == '1') && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    if ($today->isSameDay($departureDate)) {
                        return 'Due to Depart';
                    } elseif ($today->isBefore($departureDate)) {
                        $daysLeft = $today->diffInDays($departureDate);
                        return '<span class="badge badge-success mr-1">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="badge badge-danger">' . $daysPassed . ' Day(s) Passed</span>';
                    }
                } elseif ($record->status == '2' && $record->return_date) {
                    $returnDate = Carbon::parse($record->return_date);
                    $remainingDays = $today->diffInDays($returnDate, false);
                    if ($today->isAfter($returnDate)) {
                        return '<span class="badge badge-danger mr-1">' . abs($remainingDays) . ' Days Passed</span>';
                    } elseif ($today->isSameDay($returnDate)) {
                        return '<span class="badge badge-warning mr-1">Today is the Return Date</span>';
                    } else {
                        return '<span class="badge badge-success mr-1">' . $remainingDays . ' Day(s) Left to Return</span>';
                    }
                }
                return '';
            })

            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
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
            ->addColumn('checkbox', function ($row) {
                if ($row->status == '2') {
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
            ->rawColumns(['return_date', 'full_name', 'return_status', 'checkbox', 'status', 'action', 'action_second'])
            ->make(true);
    }

    public function FirstUserDashboardArrival(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $currentYear = date('Y');
        $today = Carbon::now();

        $query = GAFTOTRAVELRECORD::where('status', '=', '2')
            ->whereDate('departure_date', '<=', $today);

        if ($startDate && $endDate) {
            $query->whereBetween('return_date', [$startDate, $endDate]);
        }

        $query->orderByRaw('DATEDIFF(return_date, CURDATE())');

        return DataTables::of($query)
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>';
            })
            ->addColumn('action_second', function ($row) {
                if ($row->status == '2') {
                    return '<div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('course.arriving.personnel', $row->id) . '" id="ReturnedBtn">Return</a>
                                <a class="dropdown-item rapatriation" href="' . route('repatriation-edit', $row->uuid) . '">Repatriation</a>
                            </div>
                        </div>';
                } else {
                    return '';
                }
            })
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
            })
            ->addColumn('return_status', function ($record) {
                $today = Carbon::now();
                if ($record->status == '2' && $record->return_date) {
                    $returnDate = Carbon::parse($record->return_date);
                    $remainingDays = $today->diffInDays($returnDate, false);
                    if ($today->isAfter($returnDate)) {
                        return '<span class="badge badge-danger mr-1">' . abs($remainingDays) . ' Days Passed</span>';
                    } elseif ($today->isSameDay($returnDate)) {
                        return '<span class="badge badge-warning mr-1">Today is the Return Date</span>';
                    } else {
                        return '<span class="badge badge-success mr-1">' . $remainingDays . ' Day(s) Left to Return</span>';
                    }
                }
                return '';
            })
            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
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
            ->rawColumns(['return_date', 'full_name', 'return_status', 'status', 'action', 'action_second'])
            ->make(true);
    }


}
