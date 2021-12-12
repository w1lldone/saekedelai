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
            'user' => $request->user()->only('name', 'email'),
            'status' => session('status')
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => [Rule::unique('users')->ignore($request->user()->id)]
        ]);

        $request->user()->update($data);

        return redirect()->back()->with('status', __('messages.success'));
    }
}
