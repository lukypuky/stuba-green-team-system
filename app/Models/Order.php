<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'order_title',
        'description',
        'quantity',
        'price_per_piece',
        'price_total',
        'currency_id',
        'created_by_user_id',
        'shop',
        'link',
        'order_priority_id',
        'order_comment',
        'delivery_date',
        'order_status_id',
        'formula_part_specify_id',
        'approval',
    ];
}
