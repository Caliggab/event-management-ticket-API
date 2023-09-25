<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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
