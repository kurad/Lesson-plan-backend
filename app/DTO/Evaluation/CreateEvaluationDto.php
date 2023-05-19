<?php

namespace App\DTO\Evaluation;

use App\DTO\InitializeDtoTrait;

class CreateEvaluationDto
{
    use InitializeDtoTrait;


    public string $content;
    public int $lessonId;
}