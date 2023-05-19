<?php

namespace App\DTO\LessonCompetence;

use App\DTO\InitializeDtoTrait;

class UpdateLessonCompetenceDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonPartId;
}
