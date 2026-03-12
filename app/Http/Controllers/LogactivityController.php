<?php

namespace App\Http\Controllers;

class LogactivityController extends Controller
{
    public function login_and_logout_activities()
    {
        // $login_and_logout = activityLog::orderBy('id', 'desc')->get();
        return view('systemsetting.usermanage.user_login_and_out_activities');
    }
}
