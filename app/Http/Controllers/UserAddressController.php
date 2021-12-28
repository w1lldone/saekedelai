<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserAddressController extends Controller
{
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('User/EditAddress', [
            'user' => $user->load('address')
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'province' => "string|required",
            'city' => "string|required",
            'district' => "string|required",
            'subdistrict' => "string|required",
            'district' => "string|required",
            "address" => "string|nullable"
        ]);

        $address = $user->address()->firstOrCreate();

        $address->update($data);

        return redirect()->back()->with('status', __('messages.success'));
    }
}
