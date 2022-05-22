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
            'harvested_at' => 'nullable|date',
            'received_at' => 'nullable|date',
            'yield' => 'nullable|integer',
            'harvest_batch' => 'nullable|string',
            'released_quantity' => 'integer|nullable',
            'ureleased_quantity' => 'integer|nullable',
            'water_content' => 'numeric|nullable|max:99',
            'dirts' => 'numeric|nullable|max:99',
            'discolors' => 'numeric|nullable|max:99',
            'splits' => 'numeric|nullable|max:99',
            'damaged' => 'numeric|nullable|max:99',
            'fungal' => 'numeric|nullable|max:99',
            'bugs' => 'numeric|nullable|max:99',
            'harvest_costs' => 'array|nullable',
            'harvest_costs.*.description' => 'string',
            'harvest_costs.*.value' => 'integer'
        ]);

        $planting->harvested_at = $request->harvested_at;
        $planting->received_at = $request->received_at;
        $planting->yield = $request->yield;
        $planting->harvest_batch = $request->harvest_batch;
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

        return redirect()->route('field.planting.postharvest', [$planting->field_id, $planting->id]);
    }
}
