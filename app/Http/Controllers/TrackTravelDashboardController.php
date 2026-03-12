<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Models\GAFTOTRAVELRECORD;
use App\Models\Personnel;
use Illuminate\Support\Facades\DB;

class TrackTravelDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $armyCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['ARMY'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $navyCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['NAVY'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $airforceCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['AIRFORCE'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $totalCount = $armyCount + $navyCount + $airforceCount;

        $armyOfficerCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['ARMY'])
            ->whereRaw('UPPER(level) = ?', ['OFFICER'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $navyOfficerCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['NAVY'])
            ->whereRaw('UPPER(level) = ?', ['OFFICER'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $airforceOfficerCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['AIRFORCE'])
            ->whereRaw('UPPER(level) = ?', ['OFFICER'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $officerTotalCount = $armyOfficerCount + $navyOfficerCount + $airforceOfficerCount;

        $armySoldierCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['ARMY'])
            ->whereRaw('UPPER(level) = ?', ['SOLDIER'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $airforceSoldierCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['AIRFORCE'])
            ->whereRaw('UPPER(level) = ?', ['SOLDIER'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();
        $soldierTotalCount = $armySoldierCount + $airforceSoldierCount;

        $navyRatingCount = Personnel::whereRaw('UPPER(arm_of_service) = ?', ['NAVY'])
            ->whereRaw('UPPER(level) = ?', ['RATING'])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();

        return view('admin.index', compact(
            'armyCount',
            'navyCount',
            'airforceCount',
            'totalCount',
            'armyOfficerCount',
            'navyOfficerCount',
            'airforceOfficerCount',
            'officerTotalCount',
            'armySoldierCount',
            'airforceSoldierCount',
            'soldierTotalCount',
            'navyRatingCount'
        ));
    }

    public function approve_departure()
    {
        $standby = GAFTOTRAVELRECORD::where('status', 0)->count();
        $dependings = GAFTOTRAVELRECORD::where('status', 1)->count();
        $departures = GAFTOTRAVELRECORD::where('status', 2)->count();
        $returned = GAFTOTRAVELRECORD::where('status', 5)->count();
        return view('deployment.traveldashbaord.first_user_record.departure_dashboard', compact('standby', 'dependings', 'departures', 'returned'));
    }

    public function officerAnalysis()
    {
        $services = ['ARMY', 'NAVY', 'AIRFORCE'];
        $serviceCharts = [];

        foreach ($services as $service) {
            $officerTotal = Personnel::whereRaw('UPPER(level) = ?', ['OFFICER'])
                ->whereRaw('UPPER(arm_of_service) = ?', [$service])
                ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
                ->count();

            $genderData = Personnel::selectRaw('UPPER(sex) as gender, COUNT(*) as total')
                ->whereRaw('UPPER(level) = ?', ['OFFICER'])
                ->whereRaw('UPPER(arm_of_service) = ?', [$service])
                ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
                ->groupBy('gender')
                ->get();

            $genderLabels = [];
            $genderCounts = [];
            foreach ($genderData as $row) {
                $key = strtoupper((string) $row->gender);
                $label = match ($key) {
                    'M', 'MALE' => 'MALE',
                    'F', 'FEMALE' => 'FEMALE',
                    default => 'OTHER/UNKNOWN',
                };
                $genderLabels[] = $label;
                $genderCounts[] = (int) $row->total;
            }

            $rankColumn = match ($service) {
                'ARMY' => 'r.army_display',
                'NAVY' => 'r.navy_display',
                'AIRFORCE' => 'r.airforce_display',
                default => 'r.rank_code',
            };

            $rankData = DB::table('personnel as p')
                ->leftJoin('ranks as r', 'r.rank_code', '=', 'p.present_rank')
                ->selectRaw("$rankColumn as rank_display, COUNT(*) as total")
                ->whereRaw('UPPER(p.level) = ?', ['OFFICER'])
                ->whereRaw('UPPER(p.arm_of_service) = ?', [$service])
                ->whereRaw('UPPER(p.status) = ?', ['ACTIVE'])
                ->groupBy('rank_display')
                ->orderByRaw('CAST(r.rank_code AS UNSIGNED) asc')
                ->get();

            $rankLabels = $rankData->pluck('rank_display')->map(function ($value) {
                return $value ?: 'UNKNOWN';
            })->values();
            $rankCounts = $rankData->pluck('total')->map(fn ($v) => (int) $v)->values();

            $serviceCharts[] = [
                'service' => $service,
                'officerTotal' => $officerTotal,
                'genderLabels' => $genderLabels,
                'genderCounts' => $genderCounts,
                'rankLabels' => $rankLabels,
                'rankCounts' => $rankCounts,
            ];
        }

        return view('admin.officers', [
            'serviceCharts' => $serviceCharts,
        ]);
    }

    public function soldierAnalysis()
    {
        $services = ['ARMY', 'AIRFORCE'];
        $serviceCharts = [];

        foreach ($services as $service) {
            $soldierTotal = Personnel::whereRaw('UPPER(level) = ?', ['SOLDIER'])
                ->whereRaw('UPPER(arm_of_service) = ?', [$service])
                ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
                ->count();

            $genderData = Personnel::selectRaw('UPPER(sex) as gender, COUNT(*) as total')
                ->whereRaw('UPPER(level) = ?', ['SOLDIER'])
                ->whereRaw('UPPER(arm_of_service) = ?', [$service])
                ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
                ->groupBy('gender')
                ->get();

            $genderLabels = [];
            $genderCounts = [];
            foreach ($genderData as $row) {
                $key = strtoupper((string) $row->gender);
                $label = match ($key) {
                    'M', 'MALE' => 'MALE',
                    'F', 'FEMALE' => 'FEMALE',
                    default => 'OTHER/UNKNOWN',
                };
                $genderLabels[] = $label;
                $genderCounts[] = (int) $row->total;
            }

            $rankColumn = match ($service) {
                'ARMY' => 'r.army_display',
                'AIRFORCE' => 'r.airforce_display',
                default => 'r.rank_code',
            };

            $rankData = DB::table('personnel as p')
                ->leftJoin('ranks as r', 'r.rank_code', '=', 'p.present_rank')
                ->selectRaw("$rankColumn as rank_display, COUNT(*) as total")
                ->whereRaw('UPPER(p.level) = ?', ['SOLDIER'])
                ->whereRaw('UPPER(p.arm_of_service) = ?', [$service])
                ->whereRaw('UPPER(p.status) = ?', ['ACTIVE'])
                ->groupBy('rank_display')
                ->orderByRaw('CAST(r.rank_code AS UNSIGNED) asc')
                ->get();

            $rankLabels = $rankData->pluck('rank_display')->map(function ($value) {
                return $value ?: 'UNKNOWN';
            })->values();
            $rankCounts = $rankData->pluck('total')->map(fn ($v) => (int) $v)->values();

            $serviceCharts[] = [
                'service' => $service,
                'total' => $soldierTotal,
                'genderLabels' => $genderLabels,
                'genderCounts' => $genderCounts,
                'rankLabels' => $rankLabels,
                'rankCounts' => $rankCounts,
            ];
        }

        return view('admin.soldiers', [
            'serviceCharts' => $serviceCharts,
        ]);
    }

    public function ratingAnalysis()
    {
        $service = 'NAVY';

        $ratingTotal = Personnel::whereRaw('UPPER(level) = ?', ['RATING'])
            ->whereRaw('UPPER(arm_of_service) = ?', [$service])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->count();

        $genderData = Personnel::selectRaw('UPPER(sex) as gender, COUNT(*) as total')
            ->whereRaw('UPPER(level) = ?', ['RATING'])
            ->whereRaw('UPPER(arm_of_service) = ?', [$service])
            ->whereRaw('UPPER(status) = ?', ['ACTIVE'])
            ->groupBy('gender')
            ->get();

        $genderLabels = [];
        $genderCounts = [];
        foreach ($genderData as $row) {
            $key = strtoupper((string) $row->gender);
            $label = match ($key) {
                'M', 'MALE' => 'MALE',
                'F', 'FEMALE' => 'FEMALE',
                default => 'OTHER/UNKNOWN',
            };
            $genderLabels[] = $label;
            $genderCounts[] = (int) $row->total;
        }

        $rankData = DB::table('personnel as p')
            ->leftJoin('ranks as r', 'r.rank_code', '=', 'p.present_rank')
            ->selectRaw("r.navy_display as rank_display, COUNT(*) as total")
            ->whereRaw('UPPER(p.level) = ?', ['RATING'])
            ->whereRaw('UPPER(p.arm_of_service) = ?', [$service])
            ->whereRaw('UPPER(p.status) = ?', ['ACTIVE'])
            ->groupBy('rank_display')
            ->orderByRaw('CAST(r.rank_code AS UNSIGNED) asc')
            ->get();

        $rankLabels = $rankData->pluck('rank_display')->map(function ($value) {
            return $value ?: 'UNKNOWN';
        })->values();
        $rankCounts = $rankData->pluck('total')->map(fn ($v) => (int) $v)->values();

        return view('admin.ratings', [
            'service' => $service,
            'total' => $ratingTotal,
            'genderLabels' => $genderLabels,
            'genderCounts' => $genderCounts,
            'rankLabels' => $rankLabels,
            'rankCounts' => $rankCounts,
        ]);
    }
    public function approve_return()
    {
        $standby = GAFTOTRAVELRECORD::where('status', 0)->count();
        $dependings = GAFTOTRAVELRECORD::where('status', 1)->count();
        $departures = GAFTOTRAVELRECORD::where('status', 2)->count();
        $returned = GAFTOTRAVELRECORD::where('status', 5)->count();
        return view('deployment.traveldashbaord.first_user_record.returned_dashboard', compact('standby', 'dependings', 'departures', 'returned'));
    }
    public function approve_arrival()
    {
        $standby = GAFTOTRAVELRECORD::where('status', 0)->count();
        $dependings = GAFTOTRAVELRECORD::where('status', 1)->count();
        $departures = GAFTOTRAVELRECORD::where('status', 2)->count();
        $returned = GAFTOTRAVELRECORD::where('status', 5)->count();
        return view('deployment.traveldashbaord.first_user_record.arrival_dashboard', compact('standby', 'dependings', 'departures', 'returned'));
    }
    public function approve_standby()
    {
        $standby = GAFTOTRAVELRECORD::where('status', 0)->count();
        $dependings = GAFTOTRAVELRECORD::where('status', 1)->count();
        $departures = GAFTOTRAVELRECORD::where('status', 2)->count();
        $returned = GAFTOTRAVELRECORD::where('status', 5)->count();
        return view('deployment.traveldashbaord.first_user_record.standby_dashboard', compact('standby', 'dependings', 'departures', 'returned'));
    }
}
