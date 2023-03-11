<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_title',
        'description',
        'user_id_created',
        'user_id_assigned',
        'type_id',
        'status_id',
        'task_priority_id',
        'division_id',
        'area_id',
        'deadline',
        'attachment',
        'hours',
    ];
}
