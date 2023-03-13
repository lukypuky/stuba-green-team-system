<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaPartSpecify extends Model
{
    use HasFactory;

    protected $fillable = [
        'formula_part_specify_title',
    ];
}
