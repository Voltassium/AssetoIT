<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index()
    {
        return Inertia::render('Devices/Index', [
            'devices' => Device::query()
                ->filter(request(['search', 'type', 'status']))
                ->sort(request(['sort_field', 'sort_direction']))
                ->with('borrowings')
                ->paginate(10)
                ->withQueryString(),

            'filters' => request()->only(['search', 'type', 'status', 'sort_field', 'sort_direction']),
            'types' => $this->getDeviceTypes()
        ]);
    }

    private function getDeviceTypes()
    {
        return Cache::remember('device_types', now()->addHour(), function() {
            return Device::distinct('type')->pluck('type');
        });
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
            'specifications' => 'nullable|string',
            'count' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', Device::getStatusOptions()),
        ]);

        // Create multiple devices based on count
        for ($i = 0; $i < $validated['count']; $i++) {
            Device::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'manufacturer' => $validated['manufacturer'],
                'specifications' => $validated['specifications'],
                'count' => 1, // Each record represents one device
                'status' => $validated['status'],
            ]);
        }

        return redirect()->route('devices.index')
            ->with('message', 'Perangkat Berhasil Ditambahkan.');
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
