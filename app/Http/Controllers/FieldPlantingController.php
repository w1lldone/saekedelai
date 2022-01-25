<?php

namespace App\Http\Controllers;

use App\Models\Field;
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
            'field' => $field->load('user')
        ]);
    }

    public function create(Field $field, Request $request)
    {
        $this->authorize('update', $field);

        return Inertia::render('Field/Planting/Create', [
            'field' => $field->load('user'),
            'varieties' => Planting::getSeedVarieties()
        ]);
    }

    public function show(Field $field, $planting)
    {
        $this->authorize('view', $field);

        $planting = $field->plantings()->with('onfarms', 'field.user')->findOrFail($planting);

        return Inertia::render('Field/Planting/Show', [
            'planting' => $planting
        ]);
    }

    public function store(Field $field, Request $request)
    {

    }
}
