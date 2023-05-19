<?php

namespace App\DTO\UserType;

use App\DTO\InitializeDtoTrait;

class CreateUserTypeDto
{
    use InitializeDtoTrait;


    public string $type;
}