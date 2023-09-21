<?php

namespace App\Models;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function ticketType() {
        return $this->belongsTo(TicketType::class);
    }
}
