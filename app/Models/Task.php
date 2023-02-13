<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'created_user_id',
        'type_id',
        'status_id',
        'priority_id',
        'division_id',
        'area_id',
        'deadline',
        'attachment',
        'hours',
    ];
}
