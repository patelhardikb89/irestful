<?php
namespace iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;

interface RetrievalAdapter {
    public function fromStringToRetrieval($string);
    public function fromHttpRequestToRetrieval(HttpRequest $httpRequest);
}
