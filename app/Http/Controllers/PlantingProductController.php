<?php

namespace App\Http\Controllers;

use App\Models\Packing;
use App\Models\Planting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlantingProductController extends Controller
{
    public function index(Planting $planting, Request $request)
    {

    }

    public function create(Planting $planting, Request $request)
    {
        $this->authorize('update', $planting->field);

        $planting->load('field.address', 'field.user')->append('product_quality');

        return Inertia::render('Field/Planting/CreateProduct', [
            'planting' => $planting,
        ]);
    }

    public function store(Planting $planting, Request $request)
    {
        $this->authorize('update', $planting->field);

        $request->validate([
            'production_date' => 'nullable|date',
            'expired_date' => 'nullable|date',
            'product_processor' => 'nullable|string',
            'product_batch' => 'nullable|string',
            'water_content' => 'numeric|nullable|max:99',
            'dirts' => 'numeric|nullable|max:99',
            'discolors' => 'numeric|nullable|max:99',
            'splits' => 'numeric|nullable|max:99',
            'damaged' => 'numeric|nullable|max:99',
            'fungal' => 'numeric|nullable|max:99',
            'bugs' => 'numeric|nullable|max:99',
        ]);

        $planting->update($request->only('production_date', 'expired_date', 'product_processor', 'product_batch'));

        $quality = $planting->qualities()->firstOrNew(['category' => 'product']);
        $quality->water_content = $request->water_content;
        $quality->dirts = $request->dirts;
        $quality->discolors = $request->discolors;
        $quality->splits = $request->splits;
        $quality->damaged = $request->damaged;
        $quality->fungal = $request->fungal;
        $quality->bugs = $request->bugs;
        $quality->save();

        return redirect()->route('field.planting.product', [$planting->field_id, $planting->id]);
    }
}
