<?php

namespace App\Http\Controllers;

use App\Models\rank;
use App\Models\Service;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class rankcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $rank = rank::get();

        return view('deployment.rank.index', compact('rank'));
    }

    public function RankAdd()
    {
        $ser = Service::all();

        return view('deployment.rank.create', compact('ser'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'rank_name' => 'required',
        ]);
        rank::create([
            'arm_of_service' => $request->arm_of_service,
            'rank_name' => $request->rank_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Rank Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-rank')->with($notification);
    }

    public function Edit($uuid)
    {
        $rank = rank::where('uuid', $uuid)->first();
        if (!$rank) {
            abort(404);
        }
        $ser = Service::all();

        return view('deployment.rank.edit', compact('rank', 'ser'));
    }

    public function Update(Request $request, $uuid)
    {
        $rank = rank::where('uuid', $uuid)->first();
        if (!$rank) {
            abort(404);
        }
        $rank->rank_name = $request->rank_name;
        $rank->arm_of_service = $request->arm_of_service;
        $rank->updated_by = Auth::user()->id;
        $rank->save();
        $notification = [
            'message' => 'Rank Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-rank')->with($notification);
    }

    public function Delete($uuid)
    {
        $rank = rank::where('uuid', $uuid)->first();
        if (!$rank) {
            abort(404);
        }
        $rank->delete();
        $notification = [
            'message' => 'Rank Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
