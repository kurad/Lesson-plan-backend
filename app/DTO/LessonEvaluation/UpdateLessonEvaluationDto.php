<?php

namespace App\DTO\LessonEvaluation;

use App\DTO\InitializeDtoTrait;

class UpdateLessonEvaluationDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonTypeId;
}
