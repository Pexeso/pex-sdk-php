<?php

namespace Pex;

class PexSearchClient extends BaseClient
{
    public function __construct(string $clientID, string $clientSecret)
    {
        parent::__construct(Lib::get()->Pex_PEX_SEARCH, $clientID, $clientSecret);
    }

    public function startSearch(PexSearchRequest $req): SearchFuture
    {
        return $this->internalStartSearch($req->getFingerprint());
    }
}
