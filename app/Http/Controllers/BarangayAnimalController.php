<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\YearlyData;

class BarangayAnimalController extends Controller
{
    public function getBarangayData()
    {
        // Fetch barangay data along with totals for livestock counts
        $barangayData = Barangay::with('yearlyData')
            ->get()
            ->map(function ($barangay) {
                // Calculate totals for backyard and commercial counts
                $backyardTotal = $barangay->yearlyData->sum('backyard_count');
                $commercialTotal = $barangay->yearlyData->sum('commercial_count');

                return [
                    'barangay_name' => $barangay->name,
                    'total_backyard' => $backyardTotal,
                    'total_commercial' => $commercialTotal,
                    'total' => $backyardTotal + $commercialTotal,
                ];
            });

        // Return the result as JSON
        return response()->json($barangayData);
    }
}