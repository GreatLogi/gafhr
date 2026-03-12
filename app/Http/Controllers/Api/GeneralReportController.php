<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GAFTOTRAVELRECORD;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GeneralReportController extends Controller
{
    public function report(Request $request)
    {
        $statusValues = [2, 5, 6];
        $data = GAFTOTRAVELRECORD::whereIn('status', $statusValues)
            ->orderBy('id', 'desc')
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
            ->rawColumns(['full_name', 'status', 'departure_date', 'return_date', 'action'])
            ->make(true);
    }
    public function report_base_on_month_weekly_daily(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $currentYear = date('Y');

        $query = GAFTOTRAVELRECORD::query();

        if ($startDate && $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('departure_date', [$startDate, $endDate])
                    ->orWhereBetween('return_date', [$startDate, $endDate]);
            });
        }

        // Restricting the records to the current year
        $query->where(function ($q) use ($currentYear) {
            $q->whereYear('departure_date', $currentYear)
                ->orWhereYear('return_date', $currentYear);
        });

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

    // public function report_base_on_month_weekly_daily(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');
    //     // Get the current year
    //     $currentYear = date('Y');
    //     // Start of the current year
    //     $startOfYear = "$currentYear-01-01";
    //     // End of the current year
    //     $endOfYear = "$currentYear-12-31";
    //     $query = GAFTOTRAVELRECORD::query();
    //     // Ensure the query only includes records within the current year
    //     $query->where(function ($q) use ($startOfYear, $endOfYear) {
    //         $q->whereBetween('departure_date', [$startOfYear, $endOfYear])
    //             ->orWhereBetween('return_date', [$startOfYear, $endOfYear]);
    //     });

    //     if ($startDate && $endDate) {
    //         $query->where(function ($q) use ($startDate, $endDate) {
    //             $q->whereBetween('departure_date', [$startDate, $endDate])
    //                 ->orWhereBetween('return_date', [$startDate, $endDate]);
    //         });
    //     }

    //     $data = $query->orderBy('id', 'desc')
    //         ->orderBy('updated_at', 'desc')
    //         ->get();

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

    // public function report_base_on_month_weekly_daily(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     $query = GAFTOTRAVELRECORD::query();

    //     if ($startDate && $endDate) {
    //         $query->where(function ($q) use ($startDate, $endDate) {
    //             $q->whereBetween('departure_date', [$startDate, $endDate])
    //                 ->orWhereBetween('return_date', [$startDate, $endDate]);
    //         });
    //     }

    //     $data = $query->orderBy('id', 'desc')
    //         ->orderBy('updated_at', 'desc')
    //         ->get();

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

    // public function report_base_on_month_weekly_daily(Request $request)
    // {
    //     $statusValues = [2, 5, 6];
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     $query = GAFTOTRAVELRECORD::whereIn('status', $statusValues);

    //     if ($startDate && $endDate) {
    //         $query->where(function ($q) use ($startDate, $endDate) {
    //             $q->whereBetween('departure_date', [$startDate, $endDate])
    //                 ->orWhereBetween('return_date', [$startDate, $endDate]);
    //         });
    //     }

    //     $data = $query->orderBy('id', 'desc')
    //         ->orderBy('updated_at', 'desc')
    //         ->get();

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
    // public function report_base_on_month_weekly_daily(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     $query = GAFTOTRAVELRECORD::query();

    //     if ($startDate && $endDate) {
    //         $query->where(function ($q) use ($startDate, $endDate) {
    //             $q->whereBetween('departure_date', [$startDate, $endDate])
    //                 ->orWhereBetween('return_date', [$startDate, $endDate]);
    //         });
    //     }

    //     $data = $query->orderBy('id', 'desc')
    //         ->orderBy('updated_at', 'desc')
    //         ->get();

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

    // public function report_base_on_month_weekly_daily(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     $query = GAFTOTRAVELRECORD::query();

    //     if ($startDate && $endDate) {
    //         $query->where(function ($q) use ($startDate, $endDate) {
    //             $q->whereBetween('departure_date', [$startDate, $endDate])
    //                 ->orWhereBetween('return_date', [$startDate, $endDate]);
    //         });
    //     }

    //     $data = $query->orderBy('id', 'desc')
    //         ->orderBy('updated_at', 'desc')
    //         ->get();

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

    public function searchfilter(Request $request)
    {
        $query = GAFTOTRAVELRECORD::query();
        $gender = $request->input('gender');
        if ($gender && in_array($gender, ['MALE', 'FEMALE'])) {
            $query->where('gender', '=', $gender);
        }
        foreach ($request->all() as $key => $value) {
            if ($value && $key !== 'gender' && in_array($key, ['svcnumber', 'rank_name', 'surname', 'first_name', 'country', 'service_category', 'status', 'departure_date', 'arrival_date'])) {
                if (in_array($key, ['departure_date', 'arrival_date'])) {
                    $query->whereDate($key, $value);
                } else {
                    $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }
        return DataTables::of($query)
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
            })
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
                        return '<span class="badge badge-success mr-1">APPROVED</span>';
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
            ->rawColumns(['full_name', 'status', 'departure_date', 'return_date', 'action'])
            ->make(true);
    }
}
