<?php

// app/Models/Barangay.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'barangay';
    
    protected $primaryKey = 'barangay_id';

    protected $fillable = ['name'];

    public function farmers()
    {
        return $this->hasMany(Farmer::class, 'barangay_id', 'barangay_id');
    }
}
