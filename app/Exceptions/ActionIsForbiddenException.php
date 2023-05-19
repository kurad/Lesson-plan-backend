<?php

namespace App\Exceptions;

use Exception;

class ActionIsForbiddenException extends Exception
{

    protected  $message =  "Can't access this resource";
}
