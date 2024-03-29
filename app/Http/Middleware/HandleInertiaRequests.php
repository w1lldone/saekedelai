<?php

namespace App\Http\Middleware;

use App\Models\Device;
use App\Models\Field;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'policy' => [
                'user.viewAny' => optional($request->user())->can('viewAny', User::class),
                'organization.viewAny' => optional($request->user())->can('viewAny', Organization::class),
                'field.viewAny' => optional($request->user())->can('viewAny', Field::class),
                'device.viewAny' => optional($request->user())->can('viewAny', Device::class)
            ],
            'status' => session('status')
        ]);
    }
}
