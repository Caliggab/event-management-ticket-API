<?php

namespace App\Models;

use App\Models\Refund;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefundDetail extends Model
{
    use HasFactory, SoftDeletes,HasUuids;

    public function refund() {
        return $this->belongsTo(Refund::class);
    }
}
