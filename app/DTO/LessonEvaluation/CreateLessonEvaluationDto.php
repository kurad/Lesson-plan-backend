<?php

namespace App\DTO\LessonEvaluation;

use App\DTO\InitializeDtoTrait;

class CreateLessonEvaluationDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonPartId;
}
