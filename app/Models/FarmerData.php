<?php

// app/Models/FarmerData.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerData extends Model
{
    use HasFactory;
    
    protected $fillable = ['farmer_id', 'kind_id', 'year', 'backyard_count', 'commercial_count'];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id', 'farmer_id');
    }

    public function kindOfAnimal()
    {
        return $this->belongsTo(KindOfAnimal::class, 'kind_id', 'Kind_ID');
    }
}

