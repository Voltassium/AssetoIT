<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::query()
            ->select('id', 'name', 'type', 'manufacturer', 'status')
            ->orderBy('name')
            ->paginate(10);

        return Inertia::render('Devices/Index', [
            'devices' => $devices
        ]);
    }

    public function create()
    {
        return Inertia::render('Devices/Create', [
            'statusOptions' => Device::getStatusOptions()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'status' => 'required|in:' . implode(',', Device::getStatusOptions()),
        ]);

        Device::create($validated);

        return redirect()->route('devices.index')->with('message', 'Device created successfully.');
    }

    public function show(Device $device)
    {
        return Inertia::render('Devices/Show', [
            'device' => $device
        ]);
    }

    public function edit(Device $device)
    {
        return Inertia::render('Devices/Edit', [
            'device' => $device,
            'statusOptions' => Device::getStatusOptions()
        ]);
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'status' => 'required|in:' . implode(',', Device::getStatusOptions()),
        ]);

        $device->update($validated);

        return redirect()->route('devices.index')->with('message', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('message', 'Device deleted successfully.');
    }
}
