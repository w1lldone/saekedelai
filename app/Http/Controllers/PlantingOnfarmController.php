<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Onfarm;
use App\Models\Planting;
use Illuminate\Http\Request;

class PlantingOnfarmController extends Controller
{
    public function create(Planting $planting, Request $request)
    {
        $this->authorize('update', $planting->field);

        $planting->load('field.user', 'field.address');

        return Inertia::render('Onfarm/Create', [
            'planting' => $planting
        ]);
    }

    public function store(Request $request, Planting $planting)
    {
        $this->authorize('update', $planting->field);

        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
            'started_at' => 'required|date',
            'finished_at' => 'nullable|date',
            'description' => 'nullable|string',
            'costs' => 'array|nullable',
            'costs.*.description' => 'string',
            'costs.*.value' => 'integer'
        ]);

        $planting->onfarms()->create($data);

        return redirect()->route('field.planting.show', [$planting->field_id, $planting->id])->with('status', __('messages.success'));
    }

    public function edit(Request $request, Planting $planting, $onfarm)
    {
        $this->authorize('update', $planting->field);

        $onfarm = $planting->onfarms()->with('planting.field.address', 'planting.field.user')->find($onfarm);

        return Inertia::render('Onfarm/Edit', [
            'onfarm' => $onfarm
        ]);
    }

    public function update(Request $request, Planting $planting, $onfarm)
    {
        $this->authorize('update', $planting->field);

        $onfarm = $planting->onfarms()->findOrFail($onfarm);

        $data = $request->validate([
            'name' => 'string',
            'category' => 'nullable|string',
            'started_at' => 'date',
            'finished_at' => 'nullable|date',
            'description' => 'nullable|string',
            'costs' => 'array|nullable',
            'costs.*.description' => 'string',
            'costs.*.value' => 'integer'
        ]);

        $onfarm->update($data);

        return redirect()->route('field.planting.show', [$planting->field_id, $planting->id, "#{$onfarm->id}"])->with('status', __('messages.success'));
    }

    public function destroy(Planting $planting, $onfarm)
    {
        $this->authorize('update', $planting->field);

        $planting->onfarms()->find($onfarm)->delete();

        return redirect()->route('field.planting.show', [$planting->field_id, $planting->id])->with('status', __('deleted'));
    }
}
