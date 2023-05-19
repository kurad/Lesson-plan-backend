<?php

namespace App\DTO\User;

use App\DTO\InitializeDtoTrait;

class UpdateUserDto
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