<?php

namespace App\Http\Controllers;

use App\Models\YearlyData;
use Illuminate\Http\Request;
use Carbon\Carbon; // For handling date and year easily
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log; // For logging

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

    public function getTopBarangaysWithMostLivestock()
    {
        // Aggregate the commercial and backyard counts per barangay
        $barangayData = YearlyData::select('barangay_id', DB::raw('SUM(commercial_count + backyard_count) as total_livestock'))
            ->groupBy('barangay_id') // Group by barangay
            ->orderByDesc('total_livestock') // Sort by total livestock count (descending)
            ->take(3) // Get the top 3 barangays with the highest livestock count
            ->get(); // Retrieve the top 3 results

        if ($barangayData->isNotEmpty()) {
            // Retrieve the related Barangay details for each top barangay
            $topBarangays = $barangayData->map(function ($data) {
                $barangay = $data->barangay; // Assumes the YearlyData model has the 'barangay' relationship
                return [
                    'barangay_name' => $barangay->name,
                    'total_livestock' => $data->total_livestock,
                    'barangay_id' => $data->barangay_id,
                ];
            });

            return response()->json($topBarangays);
        }

        return response()->json(['message' => 'No barangay data available'], 404);
    }

    public function generateInsights(Request $request)
    {
        // Fetch livestock data
        $yearlyData = YearlyData::selectRaw('year, SUM(commercial_count + backyard_count) as total_livestock_count')
                                ->groupBy('year')
                                ->orderBy('year', 'asc')
                                ->get();
    
        $dataSummary = $yearlyData->map(function ($item) {
            return "Year: {$item->year}, Livestock Count: {$item->total_livestock_count}";
        })->join(". ");
    
        try {
            $client = new Client();
            $prompt = "You are an agricultural advisor analyzing livestock trends. Here is the data:\n$dataSummary\n\nBased on this data, identify patterns, provide actionable insights, and suggest strategies to improve livestock counts. Keep the insights concise and practical.";
    
            // Log the prompt for debugging
            Log::info('Prompt sent to Cohere:', ['prompt' => $prompt]);
    
            $response = $client->post('https://api.cohere.ai/generate', [
                'headers' => [
                    'Authorization' => 'Bearer '. env('COHERE_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'command-xlarge',
                    'prompt' => $prompt,
                    'max_tokens' => 200,
                ],
            ]);
    
            $result = json_decode($response->getBody(), true);
    
            // Extract only the `text` field
            $insights = $result['text'] ?? "No insights generated.";
    
            // Log the extracted insights
            Log::info('Extracted Insights:', ['insights' => $insights]);
    
            return response()->json([
                'data' => $yearlyData,
                'insights' => $insights,
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating insights:', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    


}
