<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function getFarmerData()
    {
        $farmers = Farmer::with('farmerData')->get();

        $response = $farmers->map(function ($farmer) {
            $totalBackyardCount = $farmer->farmerData->sum('backyard_count');
            $totalCommercialCount = $farmer->farmerData->sum('commercial_count');
            $totalCount = $totalBackyardCount + $totalCommercialCount;

            return [
                'farmer_name' => $farmer->first_name . ' ' . $farmer->last_name,
                'contact' => $farmer->contact,
                'total_count' => $totalCount,
            ];
        });

        return response()->json($response);
    }
    public function getFarmerDetails()
    {
        // Fetch all farmers with their related barangay and added date
        $farmers = Farmer::with('barangay') // Eager load the barangay relation
            ->select('first_name', 'last_name', 'contact', 'barangay_id', 'created_at')
            ->get()
            ->map(function ($farmer) {
                return [
                    'farmer_name' => $farmer->first_name . ' ' . $farmer->last_name,
                    'barangay' => $farmer->barangay->name,
                    'contact' => $farmer->contact,
                    'added_date' => $farmer->created_at->toDateString(),
                ];
            });

        if ($farmers->isNotEmpty()) {
            return response()->json($farmers);
        }

        return response()->json(['message' => 'No farmer data found'], 404);
    }
}
