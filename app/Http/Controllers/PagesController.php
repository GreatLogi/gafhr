<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        $user->generateAndSendOTP();
        session(['otp_verified' => false]);

        return redirect()->route('otp.verify');
    }
    public function Log_in(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        $now = Carbon::now();
        $todayDate = $now->toDateTimeString();
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            if ($user->status == 1) {
                $activityLog = [
                    'uuid' => Str::uuid(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'description' => 'has logged in',
                    'date_time' => $todayDate,
                ];
                DB::table('activity_logs')->insert($activityLog);
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Your account is deactivated. Please Contact the Admin']);
            }
        }

        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    public function Logout()
    {
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $dt = Carbon::now();
        $todayDate = $dt->toDateTimeString();
        $activityLog = [
            'uuid' => Str::uuid(),
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        session()->forget('otp_verified');
        return redirect()->route('login')->with('success', 'User Logout Successfully');
    }

    public function verifyaccount()
    {
        return view('systemsetting.user account.verifyaccount');
    }

    public function resetpassword()
    {
        return view('auth.forgot-password');
    }

    public function resetpasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No account found for this email.'])->withInput();
        }

        $user->password = bcrypt($request->password);
        $user->password_changed_at = now();
        $user->password_expiry = Carbon::parse($user->password_changed_at)->addDays(90);
        $user->save();

        return redirect()->route('login')->with('info', 'Password changed successfully. Please log in.');
    }
}
