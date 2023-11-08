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
