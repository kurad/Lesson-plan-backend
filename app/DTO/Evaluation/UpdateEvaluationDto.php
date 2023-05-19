<?php

namespace App\DTO\Evaluation;

use App\DTO\InitializeDtoTrait;

class UpdateEvaluationDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonId;
}