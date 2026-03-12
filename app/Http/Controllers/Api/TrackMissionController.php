<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GAFTOTRAVELRECORD;
use Yajra\DataTables\DataTables;

class TrackMissionController extends Controller
{
    public function TrackMissionData()
    {
        $data = GAFTOTRAVELRECORD::orderBy('id', 'desc')->orderBy('updated_at', 'desc')->get();
        return DataTables::of($data)
            ->editColumn('departure_date', function ($record) {
                return $record->departure_date ? date('d M, Y', strtotime($record->departure_date)) : '';
            })
            ->editColumn('return_date', function ($record) {
                return $record->return_date ? date('d M, Y', strtotime($record->return_date)) : '';
            })
        // ->editColumn('status', function ($record) {
        //     switch ($record->status) {
        //         case '0':
        //             return '<span class="badge badge-info mr-1">STANDBY</span>';
        //         case '1':
        //             return '<span class="badge badge-info mr-1">APPROVED</span>';
        //         case '2':
        //             return '<span class="badge badge-success mr-1">TRAVELED</span>';
        //         case '3':
        //             return '<span class="badge badge-danger mr-1">CANCELLED</span>';
        //         case '4':
        //             return '<span class="badge badge-info mr-1">RESCHEDULED</span>';
        //         case '5':
        //             return '<span class="badge badge-secondary mr-1">RETURNED</span>';
        //         case '6':
        //             return '<span class="badge badge-secondary mr-1">REPATRIATED</span>';
        //         default:
        //             return '';
        //     }
        // })
            ->editColumn('status', function ($record) {
                switch ($record->status) {
                    case '0':
                        return 'STANDBY';
                    case '1':
                        return 'APPROVED';
                    case '2':
                        return 'TRAVELED';
                    case '3':
                        return 'CANCELLED';
                    case '4':
                        return 'RESCHEDULED';
                    case '5':
                        return 'RETURNED';
                    case '6':
                        return 'REPATRIATED';
                    default:
                        return '';
                }
            })
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
            })
            ->addColumn('action', function ($record) {
                $editRoute = $record->service_category == 'CIVILIAN' ? route('edit-civilian-record', $record->uuid) : route('edit-record', $record->uuid);
                return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="' . $editRoute . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('delete-record', $record->uuid) . '" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
        // ->addColumn('action', function ($record) {
        //     return '<a class="btn btn-info btn-sm" href="' . route('record.details', $record->uuid) . '"><i class="fa fa-eye"></i></a>
        //     <a class="btn btn-primary btn-sm" href="' . route('edit-record', $record->uuid) . '"><i class="feather icon-edit"></i></a>
        //             <a class="btn btn-danger btn-sm" href="' . route('delete-record', $record->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
        // })
            ->rawColumns(['status', 'departure_date', 'return_date', 'full_name', 'action'])
            ->make(true);
    }
    public function report_base_on_month_weekly_daily(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $currentYear = date('Y');
        $query = GAFTOTRAVELRECORD::query();
        $query->whereYear('departure_date', $currentYear)
              ->orWhereYear('return_date', $currentYear);
    
        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('departure_date', [$startDate, $endDate])
                  ->orWhereBetween('return_date', [$startDate, $endDate]);
            });
        }
    
        $data = $query->orderBy('id', 'desc')
                      ->orderBy('updated_at', 'desc')
                      ->get();
    
        return DataTables::of($data)
            ->editColumn('departure_date', function ($record) {
                return $record->departure_date ? date('d M, Y', strtotime($record->departure_date)) : '';
            })
            ->editColumn('return_date', function ($record) {
                return $record->return_date ? date('d M, Y', strtotime($record->return_date)) : '';
            })
            ->editColumn('status', function ($record) {
                switch ($record->status) {
                    case '0':
                        return '<span class="badge badge-warning mr-1">STANDBY</span>';
                    case '1':
                        return '<span class="badge badge-primary mr-1">APPROVE</span>';
                    case '2':
                        return '<span class="badge badge-success mr-1">TRAVELED</span>';
                    case '3':
                        return '<span class="badge badge-danger mr-1">CANCELLED</span>';
                    case '4':
                        return '<span class="badge badge-info mr-1">RESCHEDULED</span>';
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
            ->rawColumns(['full_name', 'status', 'departure_date', 'return_date'])
            ->make(true);
    }
    

//     public function report_base_on_month_weekly_daily(Request $request)
// {
//     $startDate = $request->input('startDate');
//     $endDate = $request->input('endDate');
//     $query = GAFTOTRAVELRECORD::query();
//     if ($startDate && $endDate) {
//         $query->where(function ($q) use ($startDate, $endDate) {
//             $q->whereBetween('departure_date', [$startDate, $endDate])
//               ->orWhereBetween('return_date', [$startDate, $endDate]);
//         });
//     }

//     $data = $query->orderBy('id', 'desc')
//                   ->orderBy('updated_at', 'desc')
//                   ->get();

//     return DataTables::of($data)
//         ->editColumn('departure_date', function ($record) {
//             return $record->departure_date ? date('d M, Y', strtotime($record->departure_date)) : '';
//         })
//         ->editColumn('return_date', function ($record) {
//             return $record->return_date ? date('d M, Y', strtotime($record->return_date)) : '';
//         })
//         ->editColumn('status', function ($record) {
//             switch ($record->status) {
//                 case '0':
//                     return '<span class="badge badge-warning mr-1">STANDBY</span>';
//                 case '1':
//                     return '<span class="badge badge-primary mr-1">APPROVE</span>';
//                 case '2':
//                     return '<span class="badge badge-success mr-1">TRAVELED</span>';
//                 case '3':
//                     return '<span class="badge badge-danger mr-1">CANCELLED</span>';
//                 case '4':
//                     return '<span class="badge badge-info mr-1">RESCHEDULED</span>';
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
//         ->rawColumns(['full_name', 'status', 'departure_date', 'return_date'])
//         ->make(true);
// }

}
