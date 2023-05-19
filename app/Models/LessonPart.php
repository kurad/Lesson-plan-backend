<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonPart extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'type',
        'duration',
        'lesson_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function teacher_activities()
    {
        return $this->hasMany(LessonPartTeacherActivity::class);
    }
}