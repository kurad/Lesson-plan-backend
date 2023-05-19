<?php

namespace App\DTO\LessonTeacherActivities;

use App\DTO\InitializeDtoTrait;

class CreateLessonTeacherActivitiesDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonPartId;
}
