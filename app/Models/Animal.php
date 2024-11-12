<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $primaryKey = 'Animal_ID';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Name',
        'Category',
        
    ];
    
    public function kindsOfAnimals()
    {
        return $this->hasMany(KindOfAnimal::class, 'animal_id', 'Animal_ID');
    }
}
