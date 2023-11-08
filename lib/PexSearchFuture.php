<?php

namespace Pex;

class PexSearchFuture
{
    private PexSearchClient $client;
    private array $lookupIDs;

    public function __construct(PexSearchClient $client, array $lookupIDs)
    {
        $this->client = $client;
        $this->lookupIDs = $lookupIDs;
    }

    public function getLookupIDs(): array
    {
        return $this->lookupIDs;
    }

    public function get(): \stdClass
    {
        return $this->client->checkSearch($this->lookupIDs);
    }
}
