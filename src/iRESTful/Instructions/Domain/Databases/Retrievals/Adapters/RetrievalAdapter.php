<?php
namespace iRESTful\Instructions\Domain\Databases\Retrievals\Adapters;
use iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\HttpRequest;

interface RetrievalAdapter {
    public function fromStringToRetrieval($string);
    public function fromHttpRequestToRetrieval(HttpRequest $httpRequest);
}
