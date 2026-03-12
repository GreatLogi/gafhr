<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Models\Mission;

class countrycontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $country = Country::orderBy('country_name')->get();
        return view('deployment.country.index', compact('country'));
    }

    public function Add()
    {
        $cours = Mission::all();
        return view('deployment.country.create', compact('cours'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'country_name' => ['required', Rule::unique('countries')],
        ]);
        Country::create([
            'country_name' => $request->country_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Country Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-country')->with($notification);
    }

    public function Edit($uuid)
    {
        $country = Country::where('uuid', $uuid)->first();
        if (!$country) {
            abort(404);
        }
        return view('deployment.country.edit', compact('country'));
    }

    public function Update(Request $request, $uuid)
    {
        $country = Country::where('uuid', $uuid)->first();
        if (!$country) {
            abort(404);
        }
        $country->country_name = $request->country_name;
        $country->updated_by = Auth::user()->id;
        $country->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-country')->with($notification);
    }

    public function Delete($uuid)
    {
        $country = Country::where('uuid', $uuid)->first();
        if (!$country) {
            abort(404);
        }
        $country->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
