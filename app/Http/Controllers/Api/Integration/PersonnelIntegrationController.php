<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Integration;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Rank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonnelIntegrationController extends Controller
{
    public function show(Request $request, string $serviceNo): JsonResponse
    {
        $expectedToken = (string) config('services.gafmission.integration_token');
        $providedToken = (string) $request->header('X-Integration-Token', '');
        if ($expectedToken === '' || !hash_equals($expectedToken, $providedToken)) {
            return response()->json([
                'message' => 'Unauthorized integration token.',
            ], 401);
        }
        $personnel = Personnel::with('organic_unit')
            ->whereRaw('UPPER(service_no) = ?', [strtoupper($serviceNo)])
            ->first();
        if (!$personnel) {
            return response()->json([
                'not_found' => true,
            ], 404);
        }

        $service = strtoupper(str_replace(' ', '', (string) $personnel->arm_of_service));
        $rank = Rank::where('rank_code', $personnel->present_rank)->first();
        $rankDisplay = $personnel->present_rank;
        if ($rank) {
            $rankDisplay = match ($service) {
                'ARMY' => $rank->army_display ?? $personnel->present_rank,
                'NAVY' => $rank->navy_display ?? $personnel->present_rank,
                'AIRFORCE' => $rank->airforce_display ?? $personnel->present_rank,
                default => $personnel->present_rank,
            };
        }

        return response()->json([
            'not_found' => false,
            'source' => 'gafhr',
            'svcnumber' => $personnel->service_no,
            'rank_name' => $rankDisplay,
            'surname' => $personnel->surname,
            'first_name' => $personnel->first_name,
            'othernames' => $personnel->other_names,
            'gender' => $personnel->sex,
            'mobile_no' => $personnel->phone,
            'blood_group' => $personnel->blood_group,
            'unit_id' => $personnel->organic_unit->unit ?? $personnel->unit_id,
            'email' => $personnel->email,
            'personnel_image' => $personnel->personnel_image,
            'service_category' => $personnel->level,
            'arm_of_service' => $personnel->arm_of_service,
        ]);
    }
}
