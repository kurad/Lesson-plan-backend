<?php

namespace App\DTO\Lesson;

use App\DTO\InitializeDtoTrait;
use Illuminate\Support\Facades\Date;

class UpdateLessonDto
{
    use InitializeDtoTrait;


    public string $lessonTitle;
    public int $unitId;
    public ?string $topicArea;
    public int $duration;
    public Date $lessonDate;
    public string $instructionalObjective;
    public ?string $knowledge;
    public ?string $skills;
    public ?string $attitudeValues;
    public ?string $description;
    public ?string $teachingMaterial;
    public ?string $reference;
}
