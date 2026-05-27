<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'city',
        'country',
        'address',
        'description',
        'stars',
        'price_per_night',
        'phone',
        'email',
        'image',
        'is_available',
        'organization_id',
    ];


    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}

