<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketType extends Model
{
    use HasFactory, SoftDeletes;

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
