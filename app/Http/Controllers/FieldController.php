<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $query = new Field();

        if ($request->filled('user_id')) {
            $query = $query->where('user_id', $request->user_id);
        }

        $query = $query->with('address:id,addressable_id,addressable_type,province,city,district', 'user:name,id', 'user.organizations:id,name')->withLastPlanting();

        $fields = $query->latest()->paginate();

        if ($request->wantsJson()) {
            return $fields;
        }

        return Inertia::render('Field/Index', [
            'initialFields' => $fields,
            'queries' => $request->except('page')
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Field::class);

        return Inertia::render('Field/Create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Field::class);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'area' => 'required|numeric',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'province' => 'string|nullable',
            'city' => 'string|nullable',
            'district' => 'string|nullable',
            'subdistrct' => 'string|nullable'
        ]);

        /** @var Field */
        $field = Field::create($request->only(['user_id', 'area', 'description', 'longitude', 'latitude']));

        $field->address()->create($request->only(['province', 'city', 'district', 'subdistrict']));

        return redirect()->route('field.show', $field)->with('status', __('messages.success'));
    }

    public function show($field)
    {
        $field = Field::withLastPlanting()->with(['user.organizations:id,name', 'address'])->findOrFail($field);

        $this->authorize('view', $field);

        if ($field->lastPlanting) {
            $field->last_activity = $field->lastPlanting->onfarms()->latest()->first();
        }

        return Inertia::render('Field/Show', [
            'field' => $field,
        ]);
    }

    public function edit(Field $field)
    {
        $this->authorize('update', $field);

        return Inertia::render('Field/Edit', [
            'field' => $field->load('address', 'user.organizations')
        ]);
    }

    public function update(Field $field, Request $request)
    {
        $this->authorize('update', $field);

        $request->validate([
            'area' => 'numeric',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'province' => 'string|nullable',
            'city' => 'string|nullable',
            'district' => 'string|nullable',
            'subdistrct' => 'string|nullable'
        ]);

        $field->update($request->only(['area', 'description', 'longitude', 'latitude']));
        $field->address->update($request->only(['province', 'city', 'district', 'subdistrict']));

        return redirect()->route('field.show', $field)->with('status', __('messages.success'));
    }

    public function destroy(Field $field)
    {
        $this->authorize('delete', $field);

        $field->delete();

        return redirect()->route('field.index')->with('status', __('messages.deleted'));
    }
}
