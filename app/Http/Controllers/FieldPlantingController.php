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

    public function show(Field $field, $planting)
    {
        $this->authorize('view', $field);

        $planting = $field->plantings()->with(['onfarms' => function ($query)
        {
            $query->with('media:id,model_id,model_type,name,disk')->orderBy('timestamp', 'desc')->orderBy('id', 'desc');
        }, 'field.user'])->findOrFail($planting);

        return Inertia::render('Field/Planting/Show', [
            'planting' => $planting
        ]);
    }

    public function store(Field $field, Request $request)
    {
        $this->authorize('update', $field);

        $request->validate([
            'started_at' => 'required|date',
            'seed_variety' => 'required|string',
            'seed_quantity' => 'required|numeric',
            'activity_cost' => 'nullable|numeric',
            'fertilizer' => 'nullable|string',
            'fertilizer_cost' => 'nullable|numeric',
            'seed_photo' => 'nullable|file|max:5120',
            'activity_photo' => 'nullable|file|max:5120',
        ]);

        $planting = $field->plantings()->create([
            'started_at' => $request->started_at,
            'seed_variety' => $request->seed_variety,
            'seed_quantity' => $request->seed_quantity,
        ]);

        /** @var Onfarm */
        $onfarm = $planting->onfarms()->create([
            'category' => 'penanaman',
            'activity' => 'Penanaman benih dan pengolahan lahan',
            'cost' => $request->activity_cost,
            'timestamp' => $request->started_at,
        ]);

        if ($request->file('seed_photo')) {
            $onfarm->addMediaFromRequest('seed_photo')->setName('Bibit')->toMediaCollection('galery');
        }

        if ($request->file('activity_photo')) {
            $onfarm->addMediaFromRequest('activity_photo')->setName('Pengolahan lahan')->toMediaCollection('galery');
        }

        if ($request->filled('fertilizer')) {
            $planting->onfarms()->create([
                'category' => 'pemupukan',
                'activity' => "Pemupukan menggunakan {$request->fertilizer}",
                'cost' => $request->fertilizer_cost,
                'timestamp' => $request->started_at,
            ]);
        }

        return redirect()->route('field.planting.show', [$field->id, $planting->id])->with('status', __('messages.success'));
    }
}
