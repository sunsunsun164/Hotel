<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Hotel extends Model
{
    use SoftDeletes;
    public function products(){
        return $this->hasMany(Product::class);
    }
}
