<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'unit_id',
        'topic_area',
        'duration',
        'date',
        'instructional_objective',
        'knowledge_and_understanding',
        'skills',
        'attitudes_and_values',
        'teaching_materials',
        'description_of_teaching',
        'reference',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lessonParts()
    {
        return $this->hasMany(LessonPart::class);
    }
}