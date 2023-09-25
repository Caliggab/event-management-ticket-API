<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Order;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'description',
        // 'price',
        'total_quantity',
        'available_quantity',
        'event_id',
        'ticket_type_id',
        'order_id',
        'status',
        'location',
        'user_id',
        'start_date_time',
        'end_date_time'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
