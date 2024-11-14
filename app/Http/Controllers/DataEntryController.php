<?php

// app/Http/Controllers/DataEntryController.php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\FarmerData;
use App\Models\KindOfAnimal;
use App\Models\YearlyData;
use App\Models\Animal;
use App\Models\Barangay;
use App\Http\Requests\StoreDataEntryRequest;
use Illuminate\Http\Request;

class DataEntryController extends Controller
{
    public function store(StoreDataEntryRequest $request)
    {
        // Step 1: Find or create the farmer using first and last names
        $farmer = Farmer::firstOrCreate(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'contact' => $request->contact
            ]        
            
        );
        sleep(2);
        // Step 2: Find or create the barangay
        $barangay = Barangay::firstOrCreate(['name' => $request->barangay_name]);
        sleep(2);
        // Step 3: Find or create the animal
        $animal = Animal::firstOrCreate(
            ['Name' => $request->animal_name],
            ['Category' => $request->category]
        );
        sleep(2);
        // Step 4: Find or create the kind of animal (breed)
        $kindOfAnimal = KindOfAnimal::firstOrCreate(
            [
                'Name' => $request->kind_of_animal,
                'animal_id' => $animal->Animal_ID
            ]
        );
        sleep(2);
        // Step 5: Set counts based on animal type
        $backyardCount = 0;
        $commercialCount = 0;
        
        if ($animal->Category === 'commercial') {
            $commercialCount = $request->quantity;
        } else {
            $backyardCount = $request->quantity;
        }

        // Step 6: Store FarmerData
        FarmerData::create([
            'farmer_id' => $farmer->farmer_id,
            'kind_id' => $kindOfAnimal->Kind_ID,
            'year' => $request->year,
            'backyard_count' => $backyardCount,
            'commercial_count' => $commercialCount,
        ]);
        sleep(2);
        // Step 7: Update YearlyData with aggregate counts
        $this->updateYearlyData($request->year, $kindOfAnimal->Kind_ID, $barangay->barangay_id);

        return response()->json(['message' => 'Data entry successful']);
    }

    protected function updateYearlyData($year, $kindId, $barangayId)
    {
        // Aggregate backyard and commercial counts from FarmerData
        $totals = FarmerData::where('year', $year)
            ->where('kind_id', $kindId)
            ->selectRaw('SUM(backyard_count) as total_backyard, SUM(commercial_count) as total_commercial')
            ->first();

        // Update or create the entry in YearlyData
        YearlyData::updateOrCreate(
            ['year' => $year, 'kind_id' => $kindId, 'barangay_id' => $barangayId],
            [
                'backyard_count' => $totals->total_backyard,
                'commercial_count' => $totals->total_commercial,
            ]
        );
    }
}
