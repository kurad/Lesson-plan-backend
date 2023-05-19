<?php

namespace App\DTO\LessonStudentActivities;

use App\DTO\InitializeDtoTrait;

class CreateLessonStudentActivitiesDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonPartId;
}
