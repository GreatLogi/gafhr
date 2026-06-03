<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CommandHq;
use App\Models\Directorate;
use App\Models\Ghq;
use App\Models\ServiceHq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class HrHierarchyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('deployment.hierarchy.mech');
    }

    public function ghqs()
    {
        return view('deployment.hierarchy.index', [
            'type' => 'ghq',
            'ghqs' => Ghq::orderBy('name')->get(),
        ]);
    }

    public function directorates()
    {
        return view('deployment.hierarchy.index', [
            'type' => 'directorate',
            'ghqs' => Ghq::orderBy('name')->get(),
            'directorates' => Directorate::with('ghq')->orderBy('directorate_name')->get(),
        ]);
    }

    public function serviceHqs()
    {
        return view('deployment.hierarchy.index', [
            'type' => 'service_hq',
            'ghqs' => Ghq::orderBy('name')->get(),
            'serviceHqs' => ServiceHq::with('ghq')->orderBy('service_name')->get(),
        ]);
    }

    public function commandHqs()
    {
        return view('deployment.hierarchy.index', [
            'type' => 'command_hq',
            'serviceHqs' => ServiceHq::orderBy('service_name')->get(),
            'commandHqs' => CommandHq::with('serviceHq')->orderBy('command_name')->get(),
        ]);
    }

    public function editGhq(string $uuid)
    {
        $record = Ghq::where('uuid', $uuid)->firstOrFail();

        return view('deployment.hierarchy.edit', [
            'type' => 'ghq',
            'record' => $record,
            'ghqs' => Ghq::orderBy('name')->get(),
            'serviceHqs' => ServiceHq::orderBy('service_name')->get(),
        ]);
    }

    public function editDirectorate(string $uuid)
    {
        $record = Directorate::where('uuid', $uuid)->firstOrFail();

        return view('deployment.hierarchy.edit', [
            'type' => 'directorate',
            'record' => $record,
            'ghqs' => Ghq::orderBy('name')->get(),
            'serviceHqs' => ServiceHq::orderBy('service_name')->get(),
        ]);
    }

    public function editServiceHq(string $uuid)
    {
        $record = ServiceHq::where('uuid', $uuid)->firstOrFail();

        return view('deployment.hierarchy.edit', [
            'type' => 'service_hq',
            'record' => $record,
            'ghqs' => Ghq::orderBy('name')->get(),
            'serviceHqs' => ServiceHq::orderBy('service_name')->get(),
        ]);
    }

    public function editCommandHq(string $uuid)
    {
        $record = CommandHq::where('uuid', $uuid)->firstOrFail();

        return view('deployment.hierarchy.edit', [
            'type' => 'command_hq',
            'record' => $record,
            'ghqs' => Ghq::orderBy('name')->get(),
            'serviceHqs' => ServiceHq::orderBy('service_name')->get(),
        ]);
    }

    public function storeGhq(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('ghqs', 'name')],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        Ghq::create($validated);

        return redirect()->route('hierarchy.ghq.index')->with([
            'message' => 'GHQ created successfully',
            'alert-type' => 'success',
        ]);
    }

    public function updateGhq(Request $request, string $uuid)
    {
        $record = Ghq::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('ghqs', 'name')->ignore($record->id)],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $record->update($validated);

        return redirect()->route('hierarchy.ghq.index')->with([
            'message' => 'GHQ updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeDirectorate(Request $request)
    {
        $validated = $request->validate([
            'ghq_id' => ['required', 'exists:ghqs,id'],
            'directorate_name' => ['required', 'string', 'max:255'],
            'directorate_code' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Directorate::create($validated);

        return redirect()->route('hierarchy.directorate.index')->with([
            'message' => 'Directorate created successfully',
            'alert-type' => 'success',
        ]);
    }

    public function updateDirectorate(Request $request, string $uuid)
    {
        $record = Directorate::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'ghq_id' => ['required', 'exists:ghqs,id'],
            'directorate_name' => ['required', 'string', 'max:255'],
            'directorate_code' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $record->update($validated);

        return redirect()->route('hierarchy.directorate.index')->with([
            'message' => 'Directorate updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeServiceHq(Request $request)
    {
        $validated = $request->validate([
            'ghq_id' => ['required', 'exists:ghqs,id'],
            'service_name' => ['required', 'string', 'max:255'],
            'service_code' => ['nullable', 'string', 'max:255'],
        ]);

        ServiceHq::create($validated);

        return redirect()->route('hierarchy.service-hq.index')->with([
            'message' => 'Service HQ created successfully',
            'alert-type' => 'success',
        ]);
    }

    public function updateServiceHq(Request $request, string $uuid)
    {
        $record = ServiceHq::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'ghq_id' => ['required', 'exists:ghqs,id'],
            'service_name' => ['required', 'string', 'max:255'],
            'service_code' => ['nullable', 'string', 'max:255'],
        ]);

        $record->update($validated);

        return redirect()->route('hierarchy.service-hq.index')->with([
            'message' => 'Service HQ updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function storeCommandHq(Request $request)
    {
        $validated = $request->validate([
            'service_hq_id' => ['required', 'exists:service_hqs,id'],
            'command_name' => ['required', 'string', 'max:255'],
            'command_code' => ['nullable', 'string', 'max:255'],
            'command_type' => ['nullable', 'string', 'max:255'],
        ]);

        CommandHq::create($validated);

        return redirect()->route('hierarchy.command-hq.index')->with([
            'message' => 'Command HQ created successfully',
            'alert-type' => 'success',
        ]);
    }

    public function updateCommandHq(Request $request, string $uuid)
    {
        $record = CommandHq::where('uuid', $uuid)->firstOrFail();
        $validated = $request->validate([
            'service_hq_id' => ['required', 'exists:service_hqs,id'],
            'command_name' => ['required', 'string', 'max:255'],
            'command_code' => ['nullable', 'string', 'max:255'],
            'command_type' => ['nullable', 'string', 'max:255'],
        ]);

        $record->update($validated);

        return redirect()->route('hierarchy.command-hq.index')->with([
            'message' => 'Command HQ updated successfully',
            'alert-type' => 'success',
        ]);
    }
}
