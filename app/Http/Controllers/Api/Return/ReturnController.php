<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\Return;

use App\Http\Controllers\Controller;
use App\Models\GAFTOTRAVELRECORD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReturnController extends Controller
{
    public function return ()
    {
        $data = GAFTOTRAVELRECORD::whereIn('status', [5, 6])->get();
        return DataTables::of($data)
            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
                    case '5':
                        return '<span class="badge badge-secondary mr-1">RETURNED</span>';
                    case '6':
                        return '<span class="badge badge-secondary mr-1">REPATRIATED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['return_date', 'status', 'action'])
            ->make(true);
    }

    public function return_from_travel(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $today = Carbon::now();
        $query = GAFTOTRAVELRECORD::whereIn('status', [5, 6]);
        if ($startDate && $endDate) {
            $query->whereBetween('return_date', [$startDate, $endDate]);
        }
        $query->orderByRaw('DATEDIFF(return_date, CURDATE())');
        $data = $query->get();
        return DataTables::of($data)
            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('return_status', function ($row) {
                switch ($row->status) {
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
            ->rawColumns(['full_name', 'return_date', 'return_status', 'action'])
            ->make(true);
    }

}
