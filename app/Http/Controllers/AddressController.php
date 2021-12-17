<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function provinces(Request $request)
    {
        $query = Province::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', "%$request->name%");
        }

        $provinces = $query->simplePaginate();

        return $provinces;
    }

    public function cities(Request $request)
    {
        $query = City::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', "%$request->name%");
        }

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        $cities = $query->simplePaginate();

        return $cities;
    }

    public function districts(Request $request)
    {
        $query = District::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', "%$request->name%");
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $district = $query->simplePaginate();

        return $district;
    }

    public function subdistricts(Request $request)
    {
        $query = Subdistrict::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', "%$request->name%");
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        $district = $query->simplePaginate();

        return $district;
    }
}
