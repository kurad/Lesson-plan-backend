<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'unit_no',
        'key_unit_competence',
        'subject_id',

    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


    public function latestLesson()
    {
        return $this->hasOne(Lesson::class)->latestOfMany();
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}