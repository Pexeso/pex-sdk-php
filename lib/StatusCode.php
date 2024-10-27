<?php

namespace Pex;

class StatusCode
{
    public const OK = 0;
    public const DeadlineExceeded = 1;
    public const PermissionDenied = 2;
    public const Unauthenticated = 3;
    public const NotFound = 4;
    public const InvalidInput = 5;
    public const OutOfMemory = 6;
    public const InternalError = 7;
    public const NotInitialized = 8;
    public const ConnectionError = 9;
    public const LookupFailed = 10;
    public const LookupTimedOut = 11;
    public const ResourceExhausted = 12;
}
