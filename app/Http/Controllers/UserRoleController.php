<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRoleController extends Controller
{
    public function update(Request $request, User $user)
    {
        $this->authorize('updateRole', $user);

        $data = $request->validate([
            'role' => [Rule::in(User::getRoles())]
        ]);

        $user->update($data);

        return redirect()->back()->with('status', __('messages.success'));
    }
}
