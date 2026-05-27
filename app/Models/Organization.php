<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invitations()
    {
        return $this->hasMany(OrganizationInvitation::class);
    }
}

