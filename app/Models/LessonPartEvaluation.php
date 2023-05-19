<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonPartEvaluation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'content',
        'lesson_part_id',
    ];

    public function lessonPart()
    {
        return $this->belongsTo(LessonPart::class);
    }
}