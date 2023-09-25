<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'order_id',
        'ticket_id',
        'atendee_name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
