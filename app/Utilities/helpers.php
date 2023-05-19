<?php

use Illuminate\Http\Response;

/**
 *
 * Retrieve the http message and status code for a given exception
 *
 * @return array
 */


function getHttpMessageAndStatusCodeFromException(Exception $exception)
{
    return [
        $exception->getMessage(),
        match (get_class($exception)) {
            InvalidDataGivenException::class => Response::HTTP_BAD_REQUEST,
            ItemNotFoundException::class => Response::HTTP_NOT_FOUND,
            ForbiddenActionException::class => Response::HTTP_FORBIDDEN,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        },
        $exception->getCode(),
    ];
}