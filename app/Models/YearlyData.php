<?php

// app/Models/YearlyData.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyData extends Model
{
    use HasFactory;


    protected $fillable = ['year', 'kind_id', 'barangay_id', 'backyard_count', 'commercial_count'];

    public function kindOfAnimal()
    {
        return $this->belongsTo(KindOfAnimal::class, 'kind_id', 'Kind_ID');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }


}
