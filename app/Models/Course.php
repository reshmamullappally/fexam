<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = ['name','slug','details','active'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($course){
            $course->slug=Str::slug($course->name);
        });

        static::updating(function($course){
            $course->slug=Str::slug($course->name);
        });
    }
}
