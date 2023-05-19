<?php

namespace App\DTO\LessonParts;

use App\DTO\InitializeDtoTrait;

class UpdateLessonPartDto
{
    use InitializeDtoTrait;

    public int $duration;

}