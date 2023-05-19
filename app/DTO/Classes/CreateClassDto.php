<?php

namespace App\DTO\Classes;

use App\DTO\InitializeDtoTrait;

class CreateClassDto
{
    use InitializeDtoTrait;


    public string $name;
    public int $size;
    public int $SEN;
    public string $location;
    //public int $userId;
}