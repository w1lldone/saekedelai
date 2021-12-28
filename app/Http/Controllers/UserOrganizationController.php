<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Organization;
use Illuminate\Http\Request;

class UserOrganizationController extends Controller
{
    public function store(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'member_type' => 'required|in:member,leader'
        ]);

        $user->organizations()->syncWithoutDetaching([ $request->organization_id => [
            'member_type' => $request->member_type
        ]]);

        return redirect()->route('user.organization.edit', $user)->with('status', __('messages.success'));
    }

    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $organizations = Organization::select('name', 'id')->get();

        return Inertia::render('User/EditOrganization', [
            'user' => $user->load('organizations'),
            'organizations' => $organizations
        ]);
    }

    public function destroy(Request $request, User $user, $organization)
    {
        $this->authorize('update', $user);

        $user->organizations()->detach($organization);

        return redirect()->back()->with('status', __('messages.deleted'));
    }
}
