<?php

namespace App\DTO\Subject;

use App\DTO\InitializeDtoTrait;

class UpdateSubjectDto
{
    use InitializeDtoTrait;


    public string $subjectName;
    public int $classId;
    //public int $userId;
}