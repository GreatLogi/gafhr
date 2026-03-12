<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\GafMissionRecord;
use Illuminate\Http\Request;

class SummaryReportMissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function minusma()
    {
        $reports = GafMissionRecord::where('mission_name', 'MINUSMA')->latest('departure_date')->get();

        return view('deployment.report.subreports.munisma', compact('reports'));
    }

    public function filter_minusma(Request $request)
    {
        $query = GafMissionRecord::query();
        $query = GafMissionRecord::where('mission_name', 'UNMISS');
        $gender = $request->input('gender');
        if ($gender && in_array($gender, ['MALE', 'FEMALE'])) {
            $query->where('gender', '=', $gender);
        }
        foreach ($request->all() as $key => $value) {
            if ($value && $key !== 'gender' && in_array($key, ['svcnumber', 'rank_name', 'surname', 'first_name', 'arm_of_service', 'ghanbatt_name', 'unit_name', 'appointment_name', 'chalk_list', 'service_category', 'status', 'departure_date', 'return_date'])) {
                if (in_array($key, ['departure_date', 'return_date'])) {
                    $query->whereDate($key, $value);
                } else {
                    $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }
        $reports = $query->get();

        return view('deployment.report.subreports.munisma', compact('reports'));
    }

    public function unmiss()
    {
        $statusValues = [2, 5, 6];
        $data = GafMissionRecord::whereIn('status', $statusValues)
            ->where('mission_name', 'UNMISS')->latest('departure_date')
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.subreports.unmiss', ['data' => $data]);
    }

    public function unifil()
    {
        $statusValues = [2, 5, 6];
        $data = GafMissionRecord::whereIn('status', $statusValues)
            ->where('mission_name', 'UNIFIL')->latest('departure_date')
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.subreports.unifil', ['data' => $data]);
    }


    public function unisfa()
    {
        $statusValues = [2, 5, 6];
        $data = GafMissionRecord::whereIn('status', $statusValues)
            ->where('mission_name', 'UNISFA')->latest('departure_date')
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.subreports.unisfa', ['data' => $data]);
    }

    public function monusco()
    {
        $reports = GafMissionRecord::where('mission_name', 'MONUSCO')->latest('departure_date')->get();

        return view('deployment.report.subreports.monusco', compact('reports'));
    }

    public function filter_monusco(Request $request)
    {
        $query = GafMissionRecord::query();
        $query = GafMissionRecord::where('mission_name', 'UNMISS');
        $gender = $request->input('gender');
        if ($gender && in_array($gender, ['MALE', 'FEMALE'])) {
            $query->where('gender', '=', $gender);
        }
        foreach ($request->all() as $key => $value) {
            if ($value && $key !== 'gender' && in_array($key, ['svcnumber', 'rank_name', 'surname', 'first_name', 'arm_of_service', 'ghanbatt_name', 'unit_name', 'appointment_name', 'chalk_list', 'service_category', 'status', 'departure_date', 'return_date'])) {
                if (in_array($key, ['departure_date', 'return_date'])) {
                    $query->whereDate($key, $value);
                } else {
                    $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }
        $reports = $query->get();

        return view('deployment.report.subreports.monusco', compact('reports'));
    }

    public function ecomig()
    {
        $statusValues = [2, 5, 6];
        $data = GafMissionRecord::whereIn('status', $statusValues)
            ->where('mission_name', 'ECOMIG')->latest('departure_date')
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.subreports.ecomig', ['data' => $data]);
    }



    public function essmgb()
    {
        $statusValues = [2, 5, 6];
        $data = GafMissionRecord::whereIn('status', $statusValues)
            ->where('mission_name', 'ESSMGB')->latest('departure_date')
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.subreports.essmgb', ['data' => $data]);
    }


    public function unisfa_ghanmed()
    {
        $statusValues = [2, 5, 6];
        $data = GafMissionRecord::whereIn('status', $statusValues)
            ->where('mission_name', 'UNISFA GHANMED')->latest('departure_date')
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.subreports.ghanmed', ['data' => $data]);
    }
}
