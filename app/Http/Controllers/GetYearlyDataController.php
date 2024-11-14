<?php

namespace App\Http\Controllers;

use App\Models\YearlyData;
use Illuminate\Http\Request;
use Carbon\Carbon; // For handling date and year easily

class GetYearlyDataController extends Controller
{
    /**
     * Get the total livestock count (commercial + backyard) for all years.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalLivestockData(Request $request)
    {
        // Aggregate the total commercial and backyard counts for all years
        $totalData = YearlyData::selectRaw('SUM(commercial_count + backyard_count) as total_livestock_count')
                               ->first();

        // Return the total livestock count as JSON
        return response()->json([
            'count' => $totalData->total_livestock_count,
        ]);
    }

    /**
     * Get the total livestock count (commercial + backyard) for the current year.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalLivestockDataForCurrentYear(Request $request)
    {
        // Get the current year
        $currentYear = Carbon::now()->year;

        // Aggregate the total commercial and backyard counts for the current year
        $totalData = YearlyData::where('year', $currentYear) // Filter by the current year
                               ->selectRaw('SUM(commercial_count + backyard_count) as total_livestock_count')
                               ->first();

        // Return the total livestock count for the current year as JSON
        return response()->json([
            'count' => $totalData->total_livestock_count,
        ]);
    }
    public function getTotalLivestockDataByYear(Request $request)
    {
        // Aggregate the total commercial and backyard counts for each year
        $totalData = YearlyData::selectRaw('year, SUM(commercial_count + backyard_count) as total_livestock_count')
                               ->groupBy('year') // Group by year
                               ->get();

        // Return the total livestock count for each year as JSON
        return response()->json($totalData);
    }
}
