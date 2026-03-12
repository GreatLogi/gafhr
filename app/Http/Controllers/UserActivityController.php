<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Models\GAFTOTRAVELRECORD;
use Yajra\DataTables\DataTables;

class UserActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function UserData()
    {
        $user = auth()->user();
        $data = GAFTOTRAVELRECORD::where('created_by', $user->id)
            ->orderByDesc('created_at')
            ->get();
        return DataTables::of($data)
            ->addColumn('user_name', function ($row) {
                return $row->user->name ?? '';
            })
            ->addColumn('action', function ($row) {
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
            ->editColumn('eta', function ($row) {
                return $row->eta?\Carbon\Carbon::parse($row->eta)->format('h:iA') : '';
            })
            ->editColumn('etd', function ($row) {
                return $row->etd?\Carbon\Carbon::parse($row->etd)->format('h:iA') : '';
            })

            ->editColumn('return_status', function ($row) {
                if ($row->return_date) {
                    $returnDate = \Carbon\Carbon::parse($row->return_date);
                    $remainingDays = now()->diffInDays($returnDate);
                    switch (true) {
                        case ($remainingDays < 0):
                            return '<span class="badge badge-danger mr-1">' . abs($remainingDays) . ' Days passed</span>';
                        case ($remainingDays == 0):
                            return '<span class="badge badge-warning mr-1">Today is the return date</span>';
                        default:
                            return $remainingDays . ' Day(s) left to return';
                    }
                } else {
                    return '<span class="badge badge-warning mr-1">Return date missing</span>';
                }
            })

            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
                    case '0':
                        return '<span class="badge badge-warning mr-1">STANDBY</span>';
                    case '1':
                        return '<span class="badge badge-primary mr-1">APPROVED</span>';
                    case '2':
                        return '<span class="badge badge-success mr-1">DEPLOYED</span>';
                    case '5':
                        return '<span class="badge badge-secondary mr-1">RETURNED</span>';
                    case '6':
                        return '<span class="badge badge-secondary mr-1">REPATRIATED</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['user_name', 'full_name', 'eta', 'etd', 'return_date', 'return_status', 'status', 'action'])
            ->make(true);
    }
}
