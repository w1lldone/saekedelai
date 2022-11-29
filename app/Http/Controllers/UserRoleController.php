<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserRoleController extends Controller
{
    public function update(Request $request, User $user)
    {
        $this->authorize('updateRole', $user);

        $data = $request->validate([
            'role' => [Rule::in(User::getRoles()), 'nullable']
        ]);

        $user->update($data);

        return redirect()->back()->with('status', __('messages.success'));
    }

    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('User/EditRole', [
            'user' => $user,
            'roles' => User::getRoles()
        ]);
    }
}
