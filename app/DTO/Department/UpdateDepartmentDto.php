<?php

namespace App\DTO\Department;

use App\DTO\InitializeDtoTrait;

class UpdateDepartmentDto
{
    use InitializeDtoTrait;


    public string $name;
}