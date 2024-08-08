<?php

namespace Pex;

class Lister
{
    private \FFI\CData $client;
    private string $endCursor;
    private int $limit;
    private bool $hasNextPage;

    public function __construct(\FFI\CData $client, string $endCursor, int $limit)
    {
        $this->client = $client;
        $this->endCursor = $endCursor;
        $this->limit = $limit;
        $this->hasNextPage = true;
    }

    public function list(): array
    {
        $defer = new Defer();

        Lib::get()->Pex_Lock();
        $defer->add(Lib::get()->Pex_Unlock);

        $req = Lib::get()->Pex_ListRequest_New();
        Error::checkMemory($req);
        $defer->add(fn () => Lib::get()->Pex_ListRequest_Delete(\FFI::addr($req)));

        $res = Lib::get()->Pex_ListResult_New();
        Error::checkMemory($res);
        $defer->add(fn () => Lib::get()->Pex_ListResult_Delete(\FFI::addr($res)));

        $status = Lib::get()->Pex_Status_New();
        Error::checkMemory($status);
        $defer->add(fn () => Lib::get()->Pex_Status_Delete(\FFI::addr($status)));

        Lib::get()->Pex_ListRequest_SetAfter($req, $this->endCursor);
        Lib::get()->Pex_ListRequest_SetLimit($req, $this->limit);

        Lib::get()->Pex_List($this->client, $req, $res, $status);
        Error::checkStatus($status);

        $json = Lib::get()->Pex_ListResult_GetJSON($res);
        $dec = json_decode($json);

        $this->endCursor = $dec->end_cursor;
        $this->hasNextPage = $dec->has_next_page;
        return $dec->entries;
    }

    public function getHasNextPage(): bool
    {
        return $this->hasNextPage;
    }

    public function getEndCursor(): string
    {
        return $this->endCursor;
    }
}
