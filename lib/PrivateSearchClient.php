<?php

namespace Pex;

class PrivateSearchClient extends BaseClient
{
    public function __construct(string $clientID, string $clientSecret)
    {
        parent::__construct(SearchType::PrivateSearch, $clientID, $clientSecret);
    }

    public function startSearch(PrivateSearchRequest $req): SearchFuture
    {
        return $this->internalStartSearch($req->getFingerprint());
    }

    public function ingest(string $providedID, Fingerprint $ft): void
    {
        $defer = new Defer();

        Lib::get()->Pex_Lock();
        $defer->add(Lib::get()->Pex_Unlock);

        $buffer = Lib::get()->Pex_Buffer_New();
        Error::checkMemory($buffer);
        $defer->add(fn () => Lib::get()->Pex_Buffer_Delete(\FFI::addr($buffer)));

        $status = Lib::get()->Pex_Status_New();
        Error::checkMemory($status);
        $defer->add(fn () => Lib::get()->Pex_Status_Delete(\FFI::addr($status)));

        Lib::get()->Pex_Buffer_Set($buffer, $ft->getBytes(), strlen($ft->getBytes()));

        Lib::get()->Pex_Ingest($this->client, $providedID, $buffer, $status);
        Error::checkStatus($status);
    }

    public function archive(string $providedID, array $ftTypes = []): void
    {
        $defer = new Defer();

        Lib::get()->Pex_Lock();
        $defer->add(Lib::get()->Pex_Unlock);

        $status = Lib::get()->Pex_Status_New();
        Error::checkMemory($status);
        $defer->add(fn () => Lib::get()->Pex_Status_Delete(\FFI::addr($status)));

        Lib::get()->Pex_Archive($this->client, $providedID, Fingerprinter::convertTypes($ftTypes), $status);
        Error::checkStatus($status);
    }

    public function listEntries(ListEntriesRequest $req): Lister
    {
        return new Lister($this->client, $req->getAfter(), $req->getLimit());
    }
}
