<?php

namespace Pex;

if (stristr(PHP_OS, 'DAR')) { // Darwin/Mac OS
    define('FFI_LIB', '/usr/local/lib/libpexsdk.dylib');
} elseif (stristr(PHP_OS, 'LIN')) { // Linux
    define('FFI_LIB', '/usr/local/lib/libpexsdk.so');
} else {
    die("Unsupported OS");
}

class Lib
{
    private static $ffi = null;

    public static function open(string $client_id, string $client_secret): void
    {
        self::$ffi = \FFI::load(__DIR__ . "/Lib.h");
        if (!self::$ffi) {
            echo "failed to load library" . PHP_EOL;
        }

        $init_status_code = self::$ffi->new("int");
        $init_status_message = self::$ffi->new("char[100]");

        self::$ffi->Pex_Init(
            $client_id,
            $client_secret,
            \FFI::addr($init_status_code),
            $init_status_message,
            \FFI::sizeof($init_status_message)
        );

        if ($init_status_code->cdata != StatusCode::OK->value) {
            throw new Error(\FFI::string($init_status_message), $init_status_code->cdata);
        }
    }

    public static function close(): void
    {
        self::$ffi->Pex_Cleanup();
    }

    public static function get(): \FFI
    {
        return self::$ffi;
    }
}
