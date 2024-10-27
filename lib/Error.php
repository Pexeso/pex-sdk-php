<?php

namespace Pex;

class Error extends \Exception
{
    private bool $retryable;

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

            $err = new Error($status_message, $status_code);
            $err->retryable = Lib::get()->Pex_Status_IsRetryable($status);
            throw $err;
        }
    }

    public function isRetryable(): bool
    {
        return $this->retryable;
    }
}
