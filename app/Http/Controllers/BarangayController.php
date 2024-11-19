<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;

class BarangayController extends Controller
{
    public function search(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('query');

        // Fetch barangays that match the search term
        $barangays = Barangay::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        // Return the search results as a JSON response
        return response()->json([
            'barangay' => $barangays,
        ]);
    }
}
