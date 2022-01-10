<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * User Filter Trait
 */
trait UserFilter
{
    public function filterUser($query, Request $request)
    {
        if ($request->filled('keyword')) {
            $query = $query->where(function ($user) use ($request) {
                $user->where('name', 'like', "%$request->keyword%")
                ->orWhere('id_number', 'like', "%$request->keyword")
                ->orWhere('email', 'like', "%$request->keyword");
            });
        }

        return $query;
    }
}
