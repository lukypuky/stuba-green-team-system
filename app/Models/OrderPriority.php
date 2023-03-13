<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPriority extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_priority_title',
    ];
}
