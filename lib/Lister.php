<?php

class Lister
{
    private Pex_Client $client;
    private string $endCursor;
    private int $limit;
    private bool $hasNextPage;

    public function __consutrct(Pex_Client $client, string $endCursor, int $limit)
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

        $res = Lib::get()->Pex_StartSearchResult_New();
        Error::checkMemory($res);
        $defer->add(fn () => Lib::get()->Pex_StartSearchResult_Delete(\FFI::addr($res)));

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
}
