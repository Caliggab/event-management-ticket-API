<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'header_image',
        'status',
        'location',
        'user_id',
        'start_date_time',
        'end_date_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTypes() {
        return $this->hasMany(TicketType::class);
    }
}