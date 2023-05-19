<?php

namespace App\DTO\UserRole;

namespace App\DTO\Role;

use App\DTO\InitializeDtoTrait;

class CreateRoleDto
{
    use InitializeDtoTrait;

    public string $name;
}

