<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationUserController extends Controller
{
    public function index(Request $request, Organization $organization)
    {
        $this->authorize('view', $organization);

        $query = $organization->users();

        $users = $query->paginate();

        return Inertia::render('Organization/UserIndex', [
            'users' => $users,
            'organization' => $organization
        ]);
    }

    public function store(Request $request, Organization $organization)
    {
        $this->authorize('update', $organization);

        $request->validate([
            'user_id' => 'required|array',
            'user_id.*' => 'numeric',
            'member_type' => 'required|in:member,leader'
        ]);

        $organization->users()->detach($request->user_id);
        $organization->users()->attach($request->user_id, ['member_type' => $request->member_type]);

        return redirect()->back()->with('status', __('messages.success'));
    }
}
