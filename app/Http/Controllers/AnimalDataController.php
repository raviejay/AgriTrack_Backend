<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use App\Models\YearlyData;
use App\Models\KindOfAnimal;

class AnimalDataController extends Controller
{
    public function getAnimalData()
    {
        $data = Animal::with([
            'kindsOfAnimals.yearlyData' => function ($query) {
                $query->select('kind_id', 'year', 'commercial_count', 'backyard_count');
            }
        ])
        ->select('Animal_ID', 'Name')
        ->get()
        ->map(function ($animal) {
            return [
                'Animal Name' => $animal->Name,
                'Kinds of Animals' => $animal->kindsOfAnimals->map(function ($kind) {
                    return [
                        'Kind Name' => $kind->Name,
                        'Yearly Data' => $kind->yearlyData->map(function ($data) {
                            return [
                                'Year' => $data->year,
                                'Commercial Count' => $data->commercial_count,
                                'Backyard Count' => $data->backyard_count,
                            ];
                        }),
                    ];
                }),
            ];
        });

        return response()->json($data);
    }
}
