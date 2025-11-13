<?php

namespace Pex;

class PexSearchClient extends BaseClient
{
    public function __construct(string $clientID, string $clientSecret)
    {
        parent::__construct(SearchType::PexSearch, $clientID, $clientSecret);
    }

    public function startSearch(PexSearchRequest $req): SearchFuture
    {
        return $this->internalStartSearch($req);
    }

    public function startISRCSearch(ISRCSearchRequest $req): SearchFuture
    {
        return $this->internalStartSearch($req);
    }
}
