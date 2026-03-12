<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        $suppliers = Service::latest()->get();

        return view('deployment.service.index', compact('suppliers'));
    }

    public function create()
    {
        return view('deployment.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'arm_of_service' => ['required', Rule::unique('services')],
        ]);
        Service::create([
            'arm_of_service' => $request->arm_of_service,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Service Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('arm-view')->with($notification);
    }

    public function Edit($uuid)
    {
        $supplier = Service::where('uuid', $uuid)->first();
        if (! $supplier) {
            abort(404);
        }

        return view('deployment.service.Edit', compact('supplier'));
    }

    public function update(Request $request)
    {
        $sullier_id = $request->uuid;
        $supplier = Service::where('uuid', $sullier_id)->first();
        if (! $supplier) {
            abort(404);
        }
        $supplier->update([
            'arm_of_service' => $request->arm_of_service,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Service Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('arm-view')->with($notification);
    }

    public function delete($uuid)
    {
        $supplier = Service::where('uuid', $uuid)->first();
        if (! $supplier) {
            abort(404);
        }
        $supplier->delete();
        $notification = [
            'message' => 'Service Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method
}
