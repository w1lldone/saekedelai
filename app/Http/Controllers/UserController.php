<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        $query->select('id', 'name', 'email', 'is_superadmin', 'role');

        $users = $query->paginate()->appends($request->all());

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $organizations = Organization::select('id', 'name')->get();

        return Inertia::render('User/Create', [
            'organizations' => $organizations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string',
            'email' => 'email|nullable|unique:users',
            'id_number' => 'required|string|min:16|max:16|unique:users',
            'phone_number' => 'string|unique:users|nullable',
            'password' => 'nullable|min:6',
            'organization_id' => 'exists:organizations,id|nullable',
            'province' => 'string|nullable',
            'city' => 'string|nullable',
            'district' => 'string|nullable',
            'subdistrict' => 'string|nullable',
            'address' => 'string|nullable'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->id_number = $request->id_number;
        $user->email = $request->email ?: $user->generateFakeEmail();
        $user->password = $request->password ?: Hash::make(Str::random());
        $user->role = 'member';
        $user->save();

        $user->address->update($request->only('province', 'city', 'district', 'subdistrict', 'address'));

        if ($request->filled('organization_id')) {
            $user->organizations()->syncWithoutDetaching([$request->organization_id => [
                'member_type' => $request->member_type
            ]]);
        }

        return redirect()->route('user.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);
        $user->load('address', 'organizations:id,name');

        return Inertia::render('User/Show', [
            'user' => $user,
            'status' => session('status'),
            'can' => [
                'update' => $request->user()->can('update', $user)
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load('address');

        return Inertia::render('User/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validate([
            'name' => 'string',
            'email' => [Rule::unique('users')->ignore($user->id), 'email'],
            'phone_number' => 'string|min:6|max:20|nullable',
            'id_number' => 'string|min:16|max:16|nullable',
        ]);

        $user->update($data);

        return redirect()->back()->with('status', __('messages.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('user.index')->with('status', __('messages.deleted'));
    }
}
