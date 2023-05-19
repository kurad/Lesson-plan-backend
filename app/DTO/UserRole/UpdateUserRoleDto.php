<?php

namespace App\DTO\UserRole;

use App\DTO\InitializeDtoTrait;

class UpdateUserRoleDto
{
    use InitializeDtoTrait;


    public int $role_id;
}