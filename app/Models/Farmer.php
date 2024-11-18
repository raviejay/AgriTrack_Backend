<?php

// app/Models/Farmer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $primaryKey = 'farmer_id';

    protected $fillable = ['first_name','last_name', 'contact', 'barangay_id'];

    public function farmerData()
    {
        return $this->hasMany(FarmerData::class, 'farmer_id', 'farmer_id');
    }
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }
}

