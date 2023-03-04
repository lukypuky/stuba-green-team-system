<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_status_id',
        'user_id',
        'meeting_id',
        'absence,'
    ];
}
