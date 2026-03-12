<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function showVerifyForm()
    {
        $user = auth()->user();
        if (empty($user->phone)) {
            return redirect()->back()->withErrors(['phone' => 'Your phone is not registered. Please contact admin for assistance.']);
        }

        $otp = $user->generateAndSendOTP(); // Generate and send OTP
        return view('auth.verify-otp', compact('otp'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|integer',
        ]);
        $user = Auth::user();
        if ($user->otp_code == $request->otp_code) {
            session(['otp_verified' => true]);
            $user->otp_code = null;
            $user->save();
            return redirect()->route('travel-dash');
        }
        return back()->withErrors(['otp_code' => 'The provided OTP code is incorrect.']);
    }
}
