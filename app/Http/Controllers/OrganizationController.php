<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Organization::class);

        $query = Organization::query();

        if ($request->filled('keyword')) {
            $query = $query->where('name', 'like', "%$request->keyword%");
        }

        $query->with('address')->withCount('users');

        $organizations = $query->paginate();

        if ($request->wantsJson()) {
            return $organizations;
        }

        return Inertia::render('Organization/Index', [
            'organizations' => $organizations,
            'status' => session('status')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Organization::class);

        return Inertia::render('Organization/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Organization::class);

        $request->validate([
            'name' => 'required|string',
            'description' => 'string|nullable',
            'province' => "string|nullable",
            'city' => "string|nullable",
            'district' => "string|nullable",
            'subdistrict' => "string|nullable",
        ]);

        $organization = Organization::create($request->only(['name', 'description']));
        $organization->address()->create($request->only([
            'province', 'city', 'district', 'subdistrict'
        ]));

        return redirect(route('organization.show', $organization));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        $this->authorize('view', $organization);

        $organization->load('address');

        return Inertia::render('Organization/Show', [
            'organization' => $organization
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit(Organization $organization)
    {
        $this->authorize('update', $organization);

        return Inertia::render('Organization/Edit', [
            'organization' => $organization->load('address')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $this->authorize('update', $organization);

        $request->validate([
            'name' => 'string',
            'description' => 'nullable',
            'province' => "string|nullable",
            'city' => "string|nullable",
            'district' => "nullable|string",
            'subdistrict' => "nullable|string",
        ]);

        $organization->update($request->only(['name', 'description']));
        $organization->address()->firstOrCreate()->update($request->only([
            'province', 'city', 'district', 'subdistrict'
        ]));

        return redirect()->route('organization.show', $organization)->with('status', __('messages.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        $this->authorize('delete', $organization);

        $organization->delete();

        return redirect()->route('organization.index')->with('status', __('messages.deleted'));
    }
}
