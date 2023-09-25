<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refundDetails()
    {
        return $this->hasMany(RefundDetail::class);
    }
}
