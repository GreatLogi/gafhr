<?php

namespace App\Http\Controllers;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ViewAudit()
    {
        return view('systemsetting.usermanage.audittrail');
    }

}
