<?php

namespace Pex;

class ListEntryRequest
{
    private string $after;
    private int $limit;

    public function setAfter(string $after)
    {
        $this->after = after;
    }

    public function getAfter(): string
    {
        return $this->after;
    }

    public function setLimit(int $limit)
    {
        $this->limit = limit;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
