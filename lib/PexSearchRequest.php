<?php

namespace Pex;

class PexSearchRequest
{
    private Fingerprint $fingerprint;

    public function __construct(Fingerprint $ft)
    {
        $this->fingerprint = $ft;
    }

    public function getFingerprint(): Fingerprint
    {
        return $this->fingerprint;
    }
}
