<?php

namespace Pex;

enum StatusCode: int
{
    case OK = 0;
    case DeadlineExceeded = 1;
    case PermissionDenied = 2;
    case Unauthenticated = 3;
    case NotFound = 4;
    case InvalidInput = 5;
    case OutOfMemory = 6;
    case InternalError = 7;
    case NotInitialized = 8;
    case ConnectionError = 9;
    case LookupFailed = 10;
    case LookupTimedOut = 11;
}

class Error extends \Exception
{
    public static function checkMemory($var, callable $cleanup = null): void
    {
        if (!$var) {
            if ($cleanup) {
                $cleanup();
            }
            throw new Error("out of memory", StatusCode::OutOfMemory);
        }
    }

    public static function checkStatus($status, callable $cleanup = null): void
    {
        if (!Lib::get()->Pex_Status_OK($status)) {
            if ($cleanup) {
                $cleanup();
            }

            $status_code = Lib::get()->Pex_Status_GetCode($status);
            $status_message = Lib::get()->Pex_Status_GetMessage($status);

            throw new Error($status_message, $status_code);
        }
    }
}
