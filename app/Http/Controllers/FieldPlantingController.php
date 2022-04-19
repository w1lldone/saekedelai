<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Onfarm;
use App\Models\Planting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FieldPlantingController extends Controller
{
    public function index(Field $field, Request $request)
    {
        $this->authorize('view', $field);

        $plantings = $field->plantings()->withLastOnfarm()->latest()->paginate();

        return Inertia::render('Field/Planting/Index', [
            'plantings' => $plantings,
            'field' => $field->load('user', 'address')
        ]);
    }

    public function create(Field $field, Request $request)
    {
        $this->authorize('update', $field);

        return Inertia::render('Field/Planting/Create', [
            'field' => $field->load('user', 'address'),
            'varieties' => Planting::getSeedVarieties()
        ]);
    }

    public function show(Field $field, $planting, Request $request)
    {
        $this->authorize('view', $field);

        $planting = $field->plantings()->with(['onfarms' => function ($query)
        {
            $query->with('media:id,model_id,model_type,name,disk')->orderBy('started_at', 'desc')->orderBy('id', 'desc');
        }, 'field.user'])->findOrFail($planting)->append('harvest_quality');

        return Inertia::render('Field/Planting/Show', [
            'planting' => $planting,
            'can' => [
                'update' => $request->user()->can('update', $planting->field)
            ]
        ]);
    }

    public function edit(Field $field, $planting)
    {
        $this->authorize('update', $field);

        $planting = $field->plantings()->findOrFail($planting);

        return Inertia::render('Field/Planting/Edit', [
            'planting' => $planting,
            'field' => $field->load('address', 'user'),
            'varieties' => Planting::getSeedVarieties()
        ]);
    }

    public function store(Field $field, Request $request)
    {
        $this->authorize('update', $field);

        $request->validate([
            'started_at' => 'required|date',
            'seed_variety' => 'required|string',
            'seed_quantity' => 'required|numeric',
        ]);

        $planting = $field->plantings()->create([
            'started_at' => $request->started_at,
            'seed_variety' => $request->seed_variety,
            'seed_quantity' => $request->seed_quantity,
        ]);

        return redirect()->route('field.planting.show', [$field->id, $planting->id])->with('status', __('messages.success'));
    }

    public function update(Request $request, Field $field, $planting)
    {
        $this->authorize('update', $field);

        $planting = $field->plantings()->findOrFail($planting);

        $data = $request->validate([
            'started_at' => 'date',
            'seed_variety' => 'string',
            'seed_quantity' => 'numeric',
        ]);

        $planting->update($data);

        return redirect()->route('field.planting.show', [$field, $planting])->with('status', __('messages.success'));
    }

    public function destroy(Field $field, $planting)
    {
        $this->authorize('update', $field);

        $planting = $field->plantings()->findOrFail($planting);

        $planting->delete();

        return redirect()->route('field.planting.index', $field)->with('status', __('messages.deleted'));
    }
}
