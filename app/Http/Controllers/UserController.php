<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        if (is_null($this->user) || !$this->user->can('superadmin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }
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
        $users = User::all();

        return view('systemsetting.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('superadmin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any user !');
        }
        $roles = Role::all();

        return view('systemsetting.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any user !');
        }
        // Validation Data
        $request->validate([
            'name' => 'required|max:50|unique:users',
            'email' => 'required|max:100|email|unique:users',
        ]);
        // Create New Admin
        $user = new User();
        $code = rand(0000, 9999);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = '1';
        $user->password = bcrypt($code);
        $user->code = $code;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash('success', 'User has been created !!');
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
        if (is_null($this->user) || !$this->user->can('superadmin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        }
        $user = User::find($id);
        $roles = Role::all();

        return view('systemsetting.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        }
        // Create New User
        $user = User::find($id);
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash('success', 'User has been updated !!');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        }
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }
        session()->flash('success', 'User has been deleted !!');

        return back();
    }
}
