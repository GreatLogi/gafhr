<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\Pending;

use App\Http\Controllers\Controller;
use App\Models\GAFTOTRAVELRECORD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PendingController extends Controller
{

    public function Pending()
    {
        $query = GAFTOTRAVELRECORD::where('status', '=', '0');
        $query->orderByRaw('
        CASE
            WHEN departure_date >= CURDATE() THEN 0
            ELSE 1
        END,
        ABS(DATEDIFF(departure_date, CURDATE())) ASC
        ');
        return DataTables::of($query)
            ->addColumn('departuredays', function ($record) {
                if ($record->status == '0' && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    $today = Carbon::now();
                    if ($today < $departureDate) {
                        $daysLeft = $today->diffInDays($departureDate);
                        return '<span class="badge badge-warning mr-1">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="badge badge-danger mr-1">' . abs($daysPassed) . ' Day(s) Passed</span>';
                    }
                }
                return '';
            })
            ->editColumn('status', function ($record) {
                switch ($record->status) {
                    case '0':
                        return '<span class="badge badge-warning mr-1">STANDBY</span>';
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
            ->addColumn('checkbox', function ($record) {
                if ($record->status == '0') {
                    return '<div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input approve-checkbox"
                                    data-record-id="' . $record->id . '"
                                    id="approve-checkbox-' . $record->id . '">
                                <label class="custom-control-label"
                                    for="approve-checkbox-' . $record->id . '"> </label>
                            </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['status', 'full_name', 'checkbox', 'departuredays', 'action'])
            ->make(true);
    }

    // public function Pending_first_user_dashboard(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');
    //     $today = Carbon::now();
    //     $query = GAFTOTRAVELRECORD::where('status', '=', '0');
    //     if ($startDate && $endDate) {
    //         $query->whereBetween('departure_date', [$startDate, $endDate]);
    //     }
    //     $query->orderByRaw('DATEDIFF(departure_date, CURDATE())');
    //     return DataTables::of($query)
    //         ->addColumn('departuredays', function ($record) {
    //             if ($record->status == '0' && $record->departure_date) {
    //                 $departureDate = Carbon::parse($record->departure_date);
    //                 $today = Carbon::now();
    //                 if ($today < $departureDate) {
    //                     $daysLeft = $today->diffInDays($departureDate);
    //                     return '<span class="badge badge-warning mr-1">' . $daysLeft . ' Day(s) Left</span>';
    //                 } else {
    //                     $daysPassed = $departureDate->diffInDays($today);
    //                     return '<span class="badge badge-danger mr-1">' . abs($daysPassed) . ' Day(s) Passed</span>';
    //                 }
    //             }
    //             return '';
    //         })
    //         ->editColumn('status', function ($record) {
    //             switch ($record->status) {
    //                 case '0':
    //                     return '<span class="badge badge-warning mr-1">STANDBY</span>';
    //                 case '2':
    //                     return '<span class="badge badge-success mr-1">TRAVELED</span>';
    //                 case '5':
    //                     return '<span class="badge badge-secondary mr-1">RETURNED</span>';
    //                 case '6':
    //                     return '<span class="badge badge-secondary mr-1">REPATRIATED</span>';
    //                 default:
    //                     return '';
    //             }
    //         })
    //         ->addColumn('full_name', function ($row) {
    //             return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
    //         })
    //         ->addColumn('action', function ($record) {
    //             return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
    //             <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>';
    //         })
    //         ->addColumn('checkbox', function ($record) {
    //             if ($record->status == '0') {
    //                 return '<div class="custom-control custom-checkbox">
    //                             <input type="checkbox" class="custom-control-input approve-checkbox"
    //                                 data-record-id="' . $record->id . '"
    //                                 id="approve-checkbox-' . $record->id . '">
    //                             <label class="custom-control-label"
    //                                 for="approve-checkbox-' . $record->id . '"> </label>
    //                         </div>';
    //             } else {
    //                 return '';
    //             }
    //         })
    //         ->rawColumns(['status', 'full_name', 'checkbox', 'departuredays', 'action'])
    //         ->make(true);
    // }

    public function Pending_first_user_dashboard(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $today = Carbon::now();

        $query = GAFTOTRAVELRECORD::where('status', '=', '0');

        if ($startDate && $endDate) {
            $query->whereBetween('departure_date', [$startDate, $endDate]);
        }

        // Custom ordering: first, those that haven't passed, then those that have
        $query->orderByRaw('
        CASE
            WHEN departure_date >= CURDATE() THEN 0
            ELSE 1
        END,
        ABS(DATEDIFF(departure_date, CURDATE())) ASC
        ');

        return DataTables::of($query)
            ->addColumn('departuredays', function ($record) use ($today) {
                if ($record->status == '0' && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    if ($today < $departureDate) {
                        $daysLeft = $today->diffInDays($departureDate);
                        return '<span class="badge badge-warning mr-1">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="badge badge-danger mr-1">' . abs($daysPassed) . ' Day(s) Passed</span>';
                    }
                }
                return '';
            })
            ->editColumn('status', function ($record) {
                switch ($record->status) {
                    case '0':
                        return '<span class="badge badge-warning mr-1">STANDBY</span>';
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
            ->addColumn('departure_date', function ($record) {
                return $record->departure_date ? Carbon::parse($record->departure_date)->format('d M, Y') : '';
            })
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>';
            })
            ->addColumn('checkbox', function ($record) {
                if ($record->status == '0') {
                    return '<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input approve-checkbox"
                                data-record-id="' . $record->id . '"
                                id="approve-checkbox-' . $record->id . '">
                            <label class="custom-control-label"
                                for="approve-checkbox-' . $record->id . '"> </label>
                        </div>';
                } else {
                    return '';
                }
            })
            ->rawColumns(['status', 'full_name', 'checkbox', 'departuredays', 'action'])
            ->make(true);
    }

}
