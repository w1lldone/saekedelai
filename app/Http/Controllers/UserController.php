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
    use UserFilter;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        $query->select('id', 'name', 'email', 'is_superadmin', 'role', 'id_number');

        $query = $this->filterUser($query, $request);

        $users = $query->with('address', 'organizations:id,name')->paginate()->appends($request->all());

        if ($request->wantsJson()) {
            return $users;
        }

        return Inertia::render('User/Index', [
            'users' => $users,
            'query' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        if ($request->filled('organization_id')) {
            $organization = Organization::select('id', 'name')->find($request->organization_id);
        }

        return Inertia::render('User/Create', [
            'organization' => $request->has('organization_id') ? $organization : null,
            'roles' => User::getRoles()
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
            'address' => 'string|nullable',
            'profile_picture' => 'nullable|file|max:5120',
            'role' => ['nullable', Rule::in(User::getRoles())]
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->id_number = $request->id_number;
        $user->email = $request->email ?: $user->generateFakeEmail();
        $user->password = $request->password ?: Hash::make(Str::random());
        $user->role = $request->role ?: 'member';
        $user->save();

        $user->address->update($request->only('province', 'city', 'district', 'subdistrict', 'address'));

        if ($request->filled('organization_id')) {
            $user->organizations()->syncWithoutDetaching([$request->organization_id => [
                'member_type' => $request->member_type
            ]]);
        }

        if ($request->file('profile_picture')) {
            $user->addMediaFromRequest('profile_picture')->toMediaCollection('profile_picture');
        }

        return redirect()->route('user.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $user)
    {
        $user = User::withProfilePicture()->with('address', 'organizations:id,name')->findOrFail($user);

        $this->authorize('view', $user);

        return Inertia::render('User/Show', [
            'user' => $user,
            'status' => session('status'),
            'can' => [
                'update' => $request->user()->can('update', $user),
                'delete' => $request->user()->can('delete', $user),
                'create' => $request->user()->can('create', User::class)
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
