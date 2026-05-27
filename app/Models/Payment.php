<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['amount', 'payment_method', 'status', 'transaction_id', 'description'])]
class Payment extends Model
{
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}