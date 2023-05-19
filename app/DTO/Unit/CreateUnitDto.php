<?php

namespace App\DTO\Unit;

use App\DTO\InitializeDtoTrait;

class CreateUnitDto
{
    use InitializeDtoTrait;


    public string $title;
    public int $unitNo;
    public string $unitCompetence;
    public int $subjectId;
}