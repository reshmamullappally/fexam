<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Exam extends Model
{
    protected $fillable = ['course_id','name','slug','active','month','year','details','file_path','image_path','exam_type'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($exam){
            $exam->slug=Str::slug($exam->name);
        });
        static::updating(function($exam){
            $exam->slug=Str::slug($exam->name);
        });

    }
    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
