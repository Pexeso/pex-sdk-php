<?php

namespace Pex;

class Fingerprint
{
    private string $bytes;

    public function __construct(string $b)
    {
        $this->bytes = $b;
    }

    public function getBytes(): string
    {
        return $this->bytes;
    }
}
