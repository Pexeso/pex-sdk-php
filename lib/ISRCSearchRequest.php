<?php

namespace Pex;

class ISRCSearchRequest
{
    private string $isrc;
    private array $ftTypes;
    private int $type;

    public function __construct(string $isrc, array $ftTypes = [], int $type = 0)
    {
        $this->isrc = $isrc;
        $this->ftTypes = $ftTypes;
        $this->type = $type;
    }

    public function getISRC(): string
    {
        return $this->isrc;
    }

    public function getFTTypes(): array
    {
        return $this->ftTypes;
    }

    public function getType(): int
    {
        return $this->type;
    }
}
