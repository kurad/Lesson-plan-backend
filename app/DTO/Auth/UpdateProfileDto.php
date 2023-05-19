<?php

namespace App\DTO\Auth;

use App\DTO\InitializeDtoTrait;

class UpdateProfileDto
{
    use InitializeDtoTrait;

    public string $firstName;
    public string $lastName;
    public string $email;
    public ?string $phoneNumber;
    public string $password;
    public int $departmentId;
    public int $userTypeId;
}
