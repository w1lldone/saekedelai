<?php

namespace App\Http\Controllers;

use App\Models\Packing;
use App\Models\Planting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PlantingPackingController extends Controller
{
    public function create(Planting $planting, Request $request)
    {
        $planting->load('field.address', 'field.user');

        $this->authorize('update', $planting->field);

        return Inertia::render('Packing/Create', [
            'planting' => $planting,
            'grades' => Packing::getGrades()
        ]);
    }

    public function store(Planting $planting, Request $request)
    {
        $this->authorize('update', $planting->field);

        $data = $request->validate([
            'initial_quantity' => 'required|integer',
            'bag_size' => 'required|integer',
            'grade' => ['required', Rule::in(Packing::getGrades())]
        ]);

        $data['current_quantity'] = $request->initial_quantity;

        $packing = $planting->packings()->create($data);

        return redirect()->route('field.planting.product', [$planting->field_id, $planting->id]);
    }

    public function destroy(Planting $planting, $packing)
    {
        $this->authorize('update', $planting->field);

        $packing = $planting->packings()->findOrFail($packing);

        $packing->delete();

        return redirect()->route('field.planting.product', [$planting->field_id, $planting->id]);
    }
}
