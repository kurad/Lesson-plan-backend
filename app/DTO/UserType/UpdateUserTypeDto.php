<?php

namespace App\DTO\UserType;

use App\DTO\InitializeDtoTrait;

class UpdateUserTypeDto
{
    use InitializeDtoTrait;


    public string $type;
}