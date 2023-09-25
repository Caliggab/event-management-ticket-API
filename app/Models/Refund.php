<?php

namespace App\Models;

use App\Models\Order;
use App\Models\RefundDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refund extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public function order() {
        return $this->belongsTo(Order::class);
    }
    
    public function refundDetails() {
        return $this->hasMany(RefundDetail::class);
    }
}
