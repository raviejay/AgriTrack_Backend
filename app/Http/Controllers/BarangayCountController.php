<?php

namespace App\Http\Controllers;

use App\Models\YearlyData;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangayCountController extends Controller
{
    public function getBarangayCounts()
    {
        $barangayCounts = DB::table('barangay')
            ->leftJoin('yearly_data', 'barangay.barangay_id', '=', 'yearly_data.barangay_id')
            ->select(
                'barangay.name as barangay_name',
                DB::raw('SUM(yearly_data.backyard_count) as total_backyard_count'),
                DB::raw('SUM(yearly_data.commercial_count) as total_commercial_count')
            )
            ->groupBy('barangay.barangay_id', 'barangay.name')
            ->get();

        return response()->json($barangayCounts);
    }
}

