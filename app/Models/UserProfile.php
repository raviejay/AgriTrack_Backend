<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * By default, Laravel assumes the table name is the plural form of the model name.
     * If your table name is `user_profiles`, this property is optional.
     */
    protected $table = 'user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * Add all fields you want to allow mass assignment for.
     */
    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
        'address'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * This is optional but helpful for type consistency.
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * Get the user that owns the profile.
     *
     * Defines the inverse one-to-one relationship with the `User` model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
