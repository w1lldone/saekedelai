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
}
