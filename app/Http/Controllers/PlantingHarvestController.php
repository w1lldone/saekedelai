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

        return Inertia::render('Harvest/Create', [
            'planting' => $planting->load('field.address', 'field.user')
        ]);
    }
}
