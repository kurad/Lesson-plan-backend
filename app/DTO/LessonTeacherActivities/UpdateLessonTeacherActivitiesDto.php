<?php

namespace App\DTO\LessonTeacherActivities;

use App\DTO\InitializeDtoTrait;

class UpdateLessonTeacherActivitiesDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonPartId;
}
