<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lesson_part_id',
        'teacher_activities',
        'learner_activities',
        'competences',
        
    ];

    public function lessonPart()
    {
        return $this->belongsTo(LessonPart::class);
    }
}
