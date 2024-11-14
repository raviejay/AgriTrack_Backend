<?php

// app/Http/Requests/StoreDataEntryRequest.php

// app/Http/Requests/StoreDataEntryRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataEntryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'barangay_name' => 'required',
            'animal_name' => 'required',
            'kind_of_animal' => 'required',
            'quantity' => 'required|integer|min:1',
            'category' => 'required',
            'year' => 'required'
        ];
    }
}

