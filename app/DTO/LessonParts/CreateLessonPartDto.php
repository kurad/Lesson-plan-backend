<?php

namespace App\DTO\LessonParts;

use App\DTO\InitializeDtoTrait;

class CreateLessonPartDto
{
    use InitializeDtoTrait;


    public string $type;
    public int $duration;
    public int $lessonId;
}