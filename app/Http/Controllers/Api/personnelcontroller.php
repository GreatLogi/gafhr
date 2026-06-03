<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\DataTables;

class personnelcontroller extends Controller
{
    public function index(Request $request)
    {
        $query = Personnel::query();

        if (Schema::hasColumn('personnel', 'service_category')) {
            $query->orderByRaw("FIELD(service_category, 'OFFICER') DESC")
                ->orderBy('service_category');
        } elseif (Schema::hasColumn('personnel', 'level')) {
            $query->orderByRaw("FIELD(level, 'OFFICER') DESC")
                ->orderBy('level');
        }

        if (Schema::hasColumn('personnel', 'arm_of_service')) {
            $query->orderByRaw("FIELD(arm_of_service, 'ARMY', 'NAVY', 'AIRFORCE')");
        }

        $query->orderBy('created_at', 'desc');

        $result = DataTables::of($query)
            ->editColumn('svcnumber', function ($record) {
                return $record->svcnumber ?? $record->service_no ?? '';
            })
            ->editColumn('initial', function ($record) {
                return $record->initial ?? $record->initials ?? trim(($record->surname ?? '') . ' ' . ($record->other_names ?? $record->othernames ?? '') . ' ' . ($record->first_name ?? ''));
            })
            ->editColumn('service_category', function ($record) {
                return $record->service_category ?? $record->level ?? '';
            })
            ->editColumn('gender', function ($record) {
                return $record->gender ?? $record->sex ?? '';
            })
            ->editColumn('mobile_no', function ($record) {
                return $record->mobile_no ?? $record->phone ?? '';
            })
            ->addColumn('rank', function ($record) {
                $rank = Rank::query()->where('rank_code', $record->present_rank)->first();

                return [
                    'rank_name' => $this->resolveRankName($rank, $record->arm_of_service, $record->present_rank),
                ];
            })
            ->addColumn('service', function ($record) {
                return [
                    'arm_of_service' => $this->resolveServiceName($record->arm_of_service),
                ];
            })
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-primary btn-sm" href="' . route('admin.personnel.edit', $record->uuid) . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('personal-delete', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);

        return $result;
    }

    private function resolveServiceName($service): string
    {
        if ($service === null) {
            return '';
        }

        return (string) $service;
    }

    private function resolveRankName(?Rank $rank, $service, $fallback): string
    {
        if (!$rank) {
            return (string) ($fallback ?? '');
        }

        $normalizedService = strtoupper(str_replace(' ', '', (string) $service));

        return match ($normalizedService) {
            'ARMY' => (string) ($rank->army_display ?? $fallback ?? ''),
            'NAVY' => (string) ($rank->navy_display ?? $fallback ?? ''),
            'AIRFORCE' => (string) ($rank->airforce_display ?? $fallback ?? ''),
            default => (string) ($rank->army_display ?? $rank->navy_display ?? $rank->airforce_display ?? $fallback ?? ''),
        };
    }
}
