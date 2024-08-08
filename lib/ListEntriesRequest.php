<?php

namespace Pex;

class ListEntriesRequest
{
    private string $after;
    private int $limit;

    public function __construct(string $after = "", int $limit = 0)
    {
        $this->after = $after;
        $this->limit = $limit;
    }

    public function setAfter(string $after): void
    {
        $this->after = after;
    }

    public function getAfter(): string
    {
        return $this->after;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = limit;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
