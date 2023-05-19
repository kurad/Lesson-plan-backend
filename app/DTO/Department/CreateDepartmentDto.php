<?php

namespace App\DTO\Department;

use App\DTO\InitializeDtoTrait;

class CreateDepartmentDto
{
    use InitializeDtoTrait;


    public string $name;
}