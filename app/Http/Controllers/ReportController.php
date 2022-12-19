<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Field;
use App\Models\Planting;
use App\Models\Organization;
use App\Models\Packing;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reports['organizations'] = Organization::count();
        $reports['farmers'] = User::has('organizations')->count();
        $reports['fields'] = Field::select('area')->sum('area');

        $reports['harvests'] = Planting::whereNotNull('yield')->leftJoin('addresses', function (JoinClause $join) {
            $join->where('addressable_type', '=', 'App\Models\Field')->on('addressable_id', '=', 'plantings.field_id');
        })
            ->select([
                'province',
                'city',
                'district',
                \DB::raw('SUM(yield) as total_yield')
            ])->groupBy('province', 'city', 'district')->take(15)->get();

        $reports['packings'] = Packing::leftJoin('plantings', function ($join) {
            $join->on('plantings.id', 'packings.planting_id');
        })->select([
            'user_id' => Field::select('user_id')->whereColumn('fields.id', 'field_id')->limit(1),
            \DB::raw('SUM(initial_quantity) * SUM(bag_size) as total_quantity'),
        ])->groupBy('user_id')->with('user:id,name')->get();

        return Inertia::render('Report/Index', [
            'reports' => $reports
        ]);
    }

    public function farmer(Request $request)
    {
        $reports = User::leftJoin('addresses', function (JoinClause $join) {
            $join->where('addressable_type', '=', 'App\Models\User')->on('addressable_id', '=', 'users.id');
        })->select([
            'province',
            'city',
            'district',
            \DB::raw('COUNT(*) as user_count'),
            \DB::raw('SUM((SELECT SUM(area) FROM fields where fields.user_id = users.id group by user_id)) as total_area')
        ])->whereNotNull('province')->where('role', 'member')
            ->groupBy('province', 'city', 'district')->orderByDesc('total_area')->get();

        return Inertia::render('Report/Farmer', [
            'reports' => $reports
        ]);
    }

    public function farmerShow(Request $request, $region)
    {
        $region = explode(";", $region);
        $province = $region[0];
        $city = $region[1];
        $district = $region[2];

        $users = User::leftJoin('addresses', function (JoinClause $join) {
            $join->where('addressable_type', '=', 'App\Models\User')->on('addressable_id', '=', 'users.id');
        })->where('province', $province)
            ->where('city', $city)
            ->where('district', $district)
            ->where('role', 'member')
            ->addSelect([
                'users.id',
                'users.name',
                \DB::raw('(SELECT SUM(area) FROM fields where fields.user_id = users.id group by user_id) as total_area')
            ])->orderByDesc('total_area')->get();

        return Inertia::render('Report/FarmerShow', [
            'users' => $users,
            'region' => "$province $city $district"
        ]);
    }

    public function planting(Request $request)
    {
        $reports = Planting::leftJoin('fields', 'field_id', '=', 'fields.id')
            ->leftJoin('organization_user', 'organization_user.user_id', '=', 'fields.user_id')
            ->groupBy('organization_id')
            ->select([
                \DB::raw('COUNT(*) as planting_count'),
                'organization_id',
            ])->with('organization.address')
            ->get();

        return Inertia::render('Report/Planting', [
            'reports' => $reports
        ]);
    }

    public function plantingShow(Organization $organization)
    {
        $users = $organization->users()->pluck('users.id');

        $reports = Planting::leftJoin('fields', 'field_id', '=', 'fields.id')
            ->whereIn('user_id', $users->toArray())
            ->select([
                \DB::raw('COUNT(*) as planting_count'),
                'user_id',
                DB::raw('(SELECT name from users where users.id = user_id) as user_name')
            ])
            ->groupBy('user_id')->get();

        return Inertia::render('Report/PlantingShow', [
            'reports' => $reports,
            'organization' => $organization
        ]);
    }

    public function packing()
    {
        $reports = Packing::leftJoin('plantings', 'planting_id', '=', 'plantings.id')
            ->leftJoin('fields', 'field_id', '=', 'fields.id')
            ->leftJoin('organization_user', 'organization_user.user_id', '=', 'fields.user_id')
            ->groupBy('organization_id')
            ->select([
                DB::raw('SUM(bag_size * initial_quantity) as total_quantity'),
                'organization_id'
            ])->with('organization.address')
            ->get();

        return Inertia::render('Report/Packing', [
            'reports' => $reports
        ]);
    }

    public function packingShow(Organization $organization)
    {
        $users = $organization->users()->pluck('users.id');

        $reports = Packing::leftJoin('plantings', 'planting_id', '=', 'plantings.id')
            ->leftJoin('fields', 'field_id', '=', 'fields.id')
            ->whereIn('user_id', $users->toArray())
            ->groupBy('user_id')
            ->select([
                DB::raw('SUM(bag_size) * SUM(initial_quantity) as total_quantity'),
                DB::raw('(SELECT name from users where users.id = user_id) as user_name')
            ])->get();

        return Inertia::render('Report/PackingShow', [
            'reports' => $reports,
            'organization' => $organization
        ]);
    }
}
