<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProfileView()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('systemsetting.usermanage.user_profile', compact('user'));
    }

    public function ProfileEdit()
    {
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('systemsetting.usermanage.edit_profile', compact('editData'));
    }

    public function ProfileStore(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->gender = $request->gender;
        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/user_images/'.$data->image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['image'] = $filename;
        }
        $data->save();
        $notification = [
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('profileview')->with($notification);
    }

    public function PasswordView()
    {
        return view('systemsetting.usermanage.edit_password');
    }

    public function PasswordUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            return redirect()->route('login');
        } else {
            return redirect()->back();
        }
    }

    public function Inactive($id)
    {
        $activeandinactive = User::findOrFail($id);
        if ($activeandinactive) {
            $activeandinactive->status = 1;
            $activeandinactive->save();
            $notification = [
                'message' => 'Changed Made Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('users.index')->with($notification);
        }
    }

    public function Active($id)
    {
        $activeandinactive = User::findOrFail($id);
        if ($activeandinactive) {
            $activeandinactive->status = 0;
            $activeandinactive->save();
            $notification = [
                'message' => 'Change Made Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('users.index')->with($notification);
        }
    }
}
