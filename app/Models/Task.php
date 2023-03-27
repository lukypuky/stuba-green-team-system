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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:m',
        'updated_at' => 'datetime:d.m.Y H:m',
    ];
}
