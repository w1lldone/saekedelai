<?php

namespace App\Http\Controllers;

use App\Models\Planting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlantingHarvestController extends Controller
{
    public function create(Planting $planting)
    {
        $this->authorize('update', $planting->field);

        $planting->append('harvest_quality');

        return Inertia::render('Harvest/Create', [
            'planting' => $planting->load('field.address', 'field.user')
        ]);
    }

    public function store(Planting $planting, Request $request)
    {
        $this->authorize('update', $planting->field);

        $request->validate([
            'harvested_at' => 'required|date',
            'yield' => 'required|integer',
            'released_quantity' => 'integer|nullable',
            'ureleased_quantity' => 'integer|nullable',
            'water_content' => 'numeric|nullable',
            'dirts' => 'numeric|nullable',
            'discolors' => 'numeric|nullable',
            'splits' => 'numeric|nullable',
            'damaged' => 'numeric|nullable',
            'fungal' => 'numeric|nullable',
            'bugs' => 'numeric|nullable',
            'harvest_costs' => 'array|nullable',
            'harvest_costs.*.description' => 'string',
            'harvest_costs.*.value' => 'integer'
        ]);

        $planting->harvested_at = $request->harvested_at;
        $planting->yield = $request->yield;
        $planting->released_quantity = $request->released_quantity;
        $planting->unreleased_quantity = $request->unreleased_quantity;
        $planting->harvest_costs = $request->harvest_costs;
        $planting->save();

        $quality = $planting->qualities()->firstOrNew(['category' => 'harvest']);
        $quality->water_content = $request->water_content;
        $quality->dirts = $request->dirts;
        $quality->discolors = $request->discolors;
        $quality->splits = $request->splits;
        $quality->damaged = $request->damaged;
        $quality->fungal = $request->fungal;
        $quality->bugs = $request->bugs;
        $quality->save();

        return redirect()->route('field.planting.show', [$planting->field_id, $planting->id]);
    }
}
