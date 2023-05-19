<?php

namespace App\DTO\Auth;

use App\DTO\InitializeDtoTrait;

class LoginDto
{
    use InitializeDtoTrait;


    public string $email;
    public string $password;
}
