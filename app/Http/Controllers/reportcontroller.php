<?php

namespace App\Http\Controllers;

use App\Models\GAFTOTRAVELRECORD;

class reportcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function report()
    {
        $statusValues = [2, 5, 6];
        $data = GAFTOTRAVELRECORD::whereIn('status', $statusValues)
            ->orderBy('id', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('deployment.report.report', ['data' => $data]);
    }
}
