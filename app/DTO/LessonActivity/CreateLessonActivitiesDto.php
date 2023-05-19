<?php

namespace App\DTO\LessonActivity;

use App\DTO\InitializeDtoTrait;

class CreateLessonActivitiesDto
{
    use InitializeDtoTrait;


    public string $teacherActivities;
    public string $learnerActivities;
    public string $competences;
    public int $lessonPartId;
}