<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\GAFTOTRAVELRECORD;
use App\Models\Personnel;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class RecordManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function RecordManager()
    {
        return view('deployment.records.record-manager.recordmanager');
    }

    public function PersonnelData()
    {
        $data = Personnel::with('organic_unit')->select([
            'id',
            'uuid',
            'service_no',
            'surname',
            'other_names',
            'first_name',
            'initials',
            'sex',
            'arm_of_service',
            'present_rank',
            'unit_id',
            'status',
        ]);

        return DataTables::of($data)
            ->addColumn('full_name', function ($row) {
                return $row->initials ?: trim($row->surname . ' ' . $row->other_names . ' ' . $row->first_name);
            })
            ->addColumn('rank_display', function ($row) {
                $service = strtoupper(str_replace(' ', '', (string) $row->arm_of_service));
                $rank = \App\Models\Rank::where('rank_code', $row->present_rank)->first();
                if (!$rank) {
                    return $row->present_rank;
                }
                return match ($service) {
                    'ARMY' => $rank->army_display ?? $row->present_rank,
                    'NAVY' => $rank->navy_display ?? $row->present_rank,
                    'AIRFORCE' => $rank->airforce_display ?? $row->present_rank,
                    default => $row->present_rank,
                };
            })
            ->addColumn('unit_name', function ($row) {
                return $row->organic_unit->unit ?? $row->unit_id;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.personnel.edit', $row->uuid) . '" class="btn btn-sm btn-primary">Edit</a>';
            })
            ->rawColumns(['full_name', 'unit_name', 'rank_display', 'action'])
            ->make(true);
    }

    public function RecordUpdate()
    {
        return view('deployment.records.record-manager.record_deployment');
    }

    public function RecordApprove()
    {
        return view('deployment.records.record-manager.approve');
    }

    public function RecordPending()
    {
        return view('deployment.records.record-manager.pending');
    }

    public function Record_Update_From_Server()
    {
        $user = auth()->user();
        $data = GAFTOTRAVELRECORD::where('status', '=', '2')->whereDate('departure_date', '<=', now())->where('created_by', $user->id)->get();
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
                                <a class="dropdown-item rapatriation" href="' . route('edit-record', $row->uuid) . '">Update Record</a>
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
            ->editColumn('return_status', function ($row) {
                if ($row->return_date) {
                    $returnDate = \Carbon\Carbon::parse($row->return_date);
                    $remainingDays = now()->diffInDays($returnDate);
                    switch (true) {
                        case ($remainingDays < 0):
                            return '<span class="mr-1 badge badge-danger">' . abs($remainingDays) . ' Days passed</span>';
                        case ($remainingDays == 0):
                            return '<span class="mr-1 badge badge-warning">Today is the return date</span>';
                        default:
                            return $remainingDays . ' Day(s) left to return';
                    }
                } else {
                    return '<span class="mr-1 badge badge-warning">Return date missing</span>';
                }
            })
            ->editColumn('return_date', function ($row) {
                return $row->return_date ? date('d M, Y', strtotime($row->return_date)) : '';
            })
            ->editColumn('status', function ($row) {
                switch ($row->status) {
                    case '2':
                        return '<span class="mr-1 badge badge-success">TRAVELED</span>';
                    case '5':
                        return '<span class="mr-1 badge badge-secondary">RETURNED</span>';
                    case '6':
                        return '<span class="mr-1 badge badge-secondary">REPATRIATED</span>';
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
            ->rawColumns(['user_name', 'full_name', 'return_date', 'checkbox', 'return_status', 'status', 'action'])
            ->make(true);
    }

    public function Record_Approve_From_Server()
    {
        $user = auth()->user();
        $data = GAFTOTRAVELRECORD::where('status', '=', '1')->where('created_by', $user->id)->get();
        return DataTables::of($data)
            ->addColumn('departuredays', function ($record) {
                if ($record->status == '1' && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    $today = Carbon::now();
                    if ($today == $departureDate) {
                        // Departure date is today
                        return 'Due to Depart';
                    } elseif ($today < $departureDate) {
                        // Count days left until departure date
                        $daysLeft = $today->diffInDays($departureDate);
                        // return $daysLeft . ' Day(s) Left';
                        return '<span class="mr-1 badge badge-primary">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        // Count days passed since departure date
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="badge badge-danger">' . $daysPassed . ' Day(s) Passed</span>';
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
                        return '<span class="mr-1 badge badge-primary">APPROVED</span>';
                    case '2':
                        return '<span class="mr-1 badge badge-success">TRAVELED</span>';
                    case '5':
                        return '<span class="mr-1 badge badge-secondary">RETURNED</span>';
                    case '6':
                        return '<span class="mr-1 badge badge-secondary">REPATRIATED</span>';
                    default:
                        return '';
                }
            })
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
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
            ->rawColumns(['return_date', 'full_name', 'departuredays', 'checkbox', 'status'])
            ->make(true);
    }

    public function Record_Pending_From_Server()
    {
        $user = auth()->user();
        $data = GAFTOTRAVELRECORD::where('status', '=', '0')->where('created_by', $user->id)->get();
        return DataTables::of($data)
            ->addColumn('departuredays', function ($record) {
                if ($record->status == '0' && $record->departure_date) {
                    $departureDate = Carbon::parse($record->departure_date);
                    $today = Carbon::now();
                    if ($today < $departureDate) {
                        $daysLeft = $today->diffInDays($departureDate);
                        return '<span class="mr-1 badge badge-warning">' . $daysLeft . ' Day(s) Left</span>';
                    } else {
                        $daysPassed = $departureDate->diffInDays($today);
                        return '<span class="mr-1 badge badge-danger">' . abs($daysPassed) . ' Day(s) Passed</span>';
                    }
                }
                return '';
            })
            ->editColumn('status', function ($record) {
                switch ($record->status) {
                    case '0':
                        return '<span class="mr-1 badge badge-warning">STANDBY</span>';
                    case '2':
                        return '<span class="mr-1 badge badge-success">TRAVELED</span>';
                    case '5':
                        return '<span class="mr-1 badge badge-secondary">RETURNED</span>';
                    case '6':
                        return '<span class="mr-1 badge badge-secondary">REPATRIATED</span>';
                    default:
                        return '';
                }
            })
            ->addColumn('full_name', function ($row) {
                return $row->surname . ', ' . $row->othernames . ' ' . $row->first_name;
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
            ->rawColumns(['status','full_name','checkbox', 'departuredays'])
            ->make(true);
    }
}
