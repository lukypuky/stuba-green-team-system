<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     * 
     * @var string
     */
    protected $primaryKey = 'report_id';

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'task_id',
        'start_time',
        'end_time',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
