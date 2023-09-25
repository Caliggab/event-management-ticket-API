<?php

namespace App\Models;

use App\Models\User;
use App\Models\Refund;
use App\Models\Ticket;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'status',
        'user_id',
        'total_price',
        'event_id',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderDetail() {
        return $this->hasOne(OrderDetail::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function refunds() {
        return $this->hasMany(Refund::class);
    }
}
