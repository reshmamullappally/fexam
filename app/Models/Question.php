<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['exam_id','question','option_a','option_b','option_c','option_d','answer','explanation'];
}
