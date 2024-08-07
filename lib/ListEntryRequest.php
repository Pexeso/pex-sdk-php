<?php

namespace Pex;

class ListEntryRequest
{
    private string $after;
    private int $limit;

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
