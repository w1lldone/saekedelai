<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Device::class);

        $devices = Device::with('address')->paginate();

        return Inertia::render('Device/Index', [
            'devices' => $devices,
            'can' => [
                'device.create' => $request->user()->can('create', Device::class)
            ]
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Device::class);

        return Inertia::render('Device/Create', [
            'integrations' => Device::availableIntegrations()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Device::class);

        $request->validate([
            'name' => 'required|string|max:100',
            'device_id' => 'required|unique:devices',
            'integration' => ['required', Rule::in(\App\Models\Device::availableIntegrations())],
            'description' => 'nullable|string|max:300',
            'payload_attributes' => 'nullable|array',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'province' => 'string|nullable',
            'city' => 'string|nullable',
            'district' => 'string|nullable',
            'subdistrict' => 'string|nullable'
        ]);

        $device = Device::create($request->only('name', 'device_id', 'integration', 'description', 'payload_attributes', 'latitude', 'longitude'));

        $device->address()->create($request->only('province', 'city', 'district', 'subdistrict'));

        return redirect()->route('device.show', $device);
    }

    public function show(Device $device, Request $request)
    {
        $this->authorize('view', $device);

        return Inertia::render('Device/Show', [
            'device' => $device->load('address'),
            'can' => [
                'device.update' => $request->user()->can('update', $device),
                'device.delete' => $request->user()->can('delete', $device)
            ]
        ]);
    }

    public function edit(Device $device)
    {
        $this->authorize('update', $device);

        return Inertia::render('Device/Edit', [
            'device' => $device->load('address')
        ]);
    }

    public function update(Device $device, Request $request)
    {
        $this->authorize('update', $device);

        $request->validate([
            'description' => 'nullable|string|max:300',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'province' => 'string|nullable',
            'city' => 'string|nullable',
            'district' => 'string|nullable',
            'subdistrict' => 'string|nullable'
        ]);

        $device->update($request->only('description', 'latitude', 'longitude'));
        $device->address->update($request->only('province', 'city', 'district', 'subdistrict'));

        return redirect()->route('device.show', $device)->with('status', __('messages.success'));
    }

    public function destroy(Device $device)
    {
        $this->authorize('delete', $device);

        $device->delete();

        return redirect()->route('device.index');
    }
}
