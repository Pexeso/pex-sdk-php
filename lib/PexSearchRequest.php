<?php

namespace Pex;

class PexSearchRequest
{
    private Fingerprint $fingerprint;
    private int $type;

    public function __construct(Fingerprint $ft, int $type = 0)
    {
        $this->fingerprint = $ft;
        $this->type = $type;
    }

    public function getFingerprint(): Fingerprint
    {
        return $this->fingerprint;
    }

    public function getType(): int
    {
        return $this->type;
    }
}
