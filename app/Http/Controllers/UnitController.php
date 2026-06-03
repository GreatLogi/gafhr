<?php

namespace App\Http\Controllers;

use App\Models\CommandHq;
use App\Models\Ghq;
use App\Models\ServiceHq;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $units = Unit::with('commandHq.serviceHq.ghq')->latest()->get();

        return view('deployment.unit.index', compact('units'));
    }

    public function Add()
    {
        $ghqs = Ghq::orderBy('name')->get();
        $serviceHqs = ServiceHq::orderBy('service_name')->get();
        $commandHqs = CommandHq::orderBy('command_name')->get();
        $supportsHierarchyChain = $this->supportsHierarchyChain();

        return view('deployment.unit.create', compact('ghqs', 'serviceHqs', 'commandHqs', 'supportsHierarchyChain'));
    }

    public function Store(Request $request)
    {
        $rules = [
            'unit_name' => 'required|string|max:255',
        ];

        if ($this->supportsHierarchyChain()) {
            $rules['ghq_id'] = 'required|integer';
            $rules['service_hq_id'] = 'required|integer';
            $rules['command_hq_id'] = 'required|integer';
        }

        $request->validate($rules);

        if ($this->supportsHierarchyChain()) {
            $this->validateHierarchyChain($request);
        }

        $unitNameColumn = $this->unitNameColumn();

        $payload = [
            $unitNameColumn => $request->unit_name,
        ];

        if (Schema::hasColumn('units', 'created_by')) {
            $payload['created_by'] = Auth::user()->id;
        }

        if (Schema::hasColumn('units', 'created_at')) {
            $payload['created_at'] = Carbon::now();
        }

        if ($this->supportsHierarchyChain()) {
            $payload['command_hq_id'] = $request->command_hq_id;
        }

        Unit::create($payload);

        $notification = [
            'message' => 'Unit Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-unit')->with($notification);
    }

    public function Edit($uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();
        if (! $unit) {
            abort(404);
        }
        $ghqs = Ghq::orderBy('name')->get();
        $serviceHqs = ServiceHq::orderBy('service_name')->get();
        $commandHqs = CommandHq::orderBy('command_name')->get();
        $supportsHierarchyChain = $this->supportsHierarchyChain();

        // $unit = Unit::findOrFail($id);
        return view('deployment.unit.edit', compact('unit', 'ghqs', 'serviceHqs', 'commandHqs', 'supportsHierarchyChain'));
    }

    public function Update(Request $request, $uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();
        if (! $unit) {
            abort(404);
        }
        $rules = [
            'unit_name' => 'required|string|max:255',
        ];

        if ($this->supportsHierarchyChain()) {
            $rules['ghq_id'] = 'required|integer';
            $rules['service_hq_id'] = 'required|integer';
            $rules['command_hq_id'] = 'required|integer';
        }

        $request->validate($rules);

        if ($this->supportsHierarchyChain()) {
            $this->validateHierarchyChain($request);
        }
        $unitNameColumn = $this->unitNameColumn();
        $unit->{$unitNameColumn} = $request->unit_name;
        if ($this->supportsHierarchyChain()) {
            $unit->command_hq_id = $request->command_hq_id;
        }
        if (Schema::hasColumn('units', 'updated_by')) {
            $unit->updated_by = Auth::user()->id;
        }
        $unit->save();
        $notification = [
            'message' => $this->supportsHierarchyChain()
                ? 'Unit Updated Successfully'
                : 'Unit Updated Successfully. Unit hierarchy link will work after the command hierarchy column is migrated.',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-unit')->with($notification);
    }

    public function Delete($uuid)
    {
        $unit = Unit::where('uuid', $uuid)->first();
        if (! $unit) {
            abort(404);
        }
        $unit->delete();
        $notification = [
            'message' => 'Unit Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    private function validateHierarchyChain(Request $request): void
    {
        $ghqId = $request->input('ghq_id');
        $serviceHqId = $request->input('service_hq_id');
        $commandHqId = $request->input('command_hq_id');

        $serviceHq = ServiceHq::query()->find($serviceHqId);
        if (! $serviceHq) {
            throw ValidationException::withMessages([
                'service_hq_id' => 'The selected Service HQ does not exist.',
            ]);
        }

        if ((string) $serviceHq->ghq_id !== (string) $ghqId) {
            throw ValidationException::withMessages([
                'service_hq_id' => 'The selected Service HQ does not belong to the selected GHQ.',
            ]);
        }

        $commandHq = CommandHq::query()->find($commandHqId);
        if (! $commandHq) {
            throw ValidationException::withMessages([
                'command_hq_id' => 'The selected Command HQ does not exist.',
            ]);
        }

        if ((string) $commandHq->service_hq_id !== (string) $serviceHqId) {
            throw ValidationException::withMessages([
                'command_hq_id' => 'The selected Command HQ does not belong to the selected Service HQ.',
            ]);
        }
    }

    private function unitNameColumn(): string
    {
        return Schema::hasColumn('units', 'unit_name') ? 'unit_name' : 'unit';
    }

    private function supportsHierarchyChain(): bool
    {
        return Schema::hasColumn('units', 'command_hq_id');
    }
}
