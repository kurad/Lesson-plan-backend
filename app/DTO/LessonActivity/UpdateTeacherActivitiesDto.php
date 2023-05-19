<?php

namespace App\DTO\LessonActivity;

use App\DTO\InitializeDtoTrait;

class UpdateTeacherActivitiesDto
{
    use InitializeDtoTrait;


    public string $teacher_activities;

}