<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KindOfAnimal extends Model
{
    use HasFactory;

    protected $primaryKey = 'Kind_ID';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Name',
        'animal_id',
        
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'Animal_ID');
    }
       // Add this relationship
       public function yearlyData()
       {
           return $this->hasMany(YearlyData::class, 'kind_id', 'Kind_ID');
       }
}
