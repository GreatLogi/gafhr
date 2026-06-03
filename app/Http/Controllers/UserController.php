<?php

namespace App\Http\Controllers;

use App\Models\CommandHq;
use App\Models\Department;
use App\Models\Directorate;
use App\Models\Ghq;
use App\Models\ServiceHq;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $inactiveUsers = User::where('status', 0)->get();
        if ($inactiveUsers->isNotEmpty()) {
            $alertMessage = 'The following user account is  inactive: ';
            foreach ($inactiveUsers as $user) {
                $alertMessage .= $user->name . ', ';
            }
            $alertMessage = rtrim($alertMessage, ', ');
            $alertMessage .= '.Please take necessary actions.';
            session()->flash('alert', $alertMessage);
        }
        $users = User::with(['ghq', 'department', 'directorate', 'serviceHq', 'commandHq', 'unit', 'roles'])->get();

        return view('systemsetting.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $roles = Role::all();
        $ghqs = Ghq::orderBy('name')->get();
        $departments = Department::orderBy('department')->get();
        $directorates = Directorate::orderBy('directorate_name')->get();
        $serviceHqs = ServiceHq::orderBy('service_name')->get();
        $commandHqs = CommandHq::orderBy('command_name')->get();
        $units = Unit::orderBy('unit_name')->get();

        return view('systemsetting.users.create', compact('roles', 'ghqs', 'departments', 'directorates', 'serviceHqs', 'commandHqs', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        // Validation Data
        $request->validate([
            'name' => 'required|max:50|unique:users',
            'email' => 'required|max:100|email|unique:users',
        ]);
        // Create New Admin
        $user = new User();
        $temporaryPassword = (string) random_int(10000000, 99999999);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->ghq_id = $request->ghq_id;
        $user->department_id = $request->department_id;
        $user->directorate_id = $request->directorate_id;
        $user->service_hq_id = $request->service_hq_id;
        $user->command_hq_id = $request->command_hq_id;
        $user->unit_id = $request->unit_id;
        $user->status = '1';
        $user->password = bcrypt($temporaryPassword);
        $user->password_changed_at = null;
        $user->password_expiry = Carbon::now()->subSecond();
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash(
            'success',
            "User has been created. Temporary password for {$user->name} is {$temporaryPassword}."
        );
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $user = User::find($id);
        $roles = Role::all();
        $ghqs = Ghq::orderBy('name')->get();
        $departments = Department::orderBy('department')->get();
        $directorates = Directorate::orderBy('directorate_name')->get();
        $serviceHqs = ServiceHq::orderBy('service_name')->get();
        $commandHqs = CommandHq::orderBy('command_name')->get();
        $units = Unit::orderBy('unit_name')->get();

        return view('systemsetting.users.edit', compact('user', 'roles', 'ghqs', 'departments', 'directorates', 'serviceHqs', 'commandHqs', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        // Create New User
        $user = User::find($id);
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->ghq_id = $request->ghq_id;
        $user->department_id = $request->department_id;
        $user->directorate_id = $request->directorate_id;
        $user->service_hq_id = $request->service_hq_id;
        $user->command_hq_id = $request->command_hq_id;
        $user->unit_id = $request->unit_id;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash('success', 'User has been updated !!');

        return back();
    }

    public function resetPassword(User $user)
    {
        $temporaryPassword = (string) random_int(10000000, 99999999);

        $user->password = bcrypt($temporaryPassword);
        $user->password_changed_at = null;
        $user->password_expiry = Carbon::now()->subSecond();
        $user->save();

        session()->flash(
            'success',
            "Temporary password for {$user->name} is {$temporaryPassword}. The user must change it after login."
        );

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }
        session()->flash('success', 'User has been deleted !!');

        return back();
    }
}
