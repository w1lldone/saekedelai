<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Auth/Profile', [
            'user' => $request->user(),
            'status' => session('status')
        ]);
    }

    public function editAddress(Request $request)
    {
        $user = $request->user()->load('address');

        return Inertia::render('Auth/ProfileAddress', [
            'user' => $user,
            'status' => session('status')
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => [Rule::unique('users')->ignore($request->user()->id), 'email'],
            'phone_number' => 'string|min:6|max:20|nullable',
            'id_number' => 'string|min:16|max:16|nullable',
        ]);

        $request->user()->update($data);

        return redirect()->back()->with('status', __('messages.success'));
    }
}
