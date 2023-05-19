<?php

namespace App\DTO\Subject;

use App\DTO\InitializeDtoTrait;

class CreateSubjectDto
{
    use InitializeDtoTrait;


    public string $subjectName;
    public int $classId;
    //public int $userId;
}