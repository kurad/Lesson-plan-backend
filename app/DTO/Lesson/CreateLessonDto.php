<?php

namespace App\DTO\Lesson;

use App\DTO\InitializeDtoTrait;

class CreateLessonDto
{
    use InitializeDtoTrait;


    public string $title;
    public int $unitId;
    public string $topicArea;
    public int $duration;
    public string $lessonDate;
    public string $instructions;
    public string $knowledge;
    public string $skills;
    public string $attitudes;
    public string $description;
    public string $materials;
    public string $reference;
}