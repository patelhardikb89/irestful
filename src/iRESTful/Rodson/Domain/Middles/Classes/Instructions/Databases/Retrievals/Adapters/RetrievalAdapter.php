<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\HttpRequest;

interface RetrievalAdapter {
    public function fromStringToRetrieval($string);
    public function fromHttpRequestToRetrieval(HttpRequest $httpRequest);
}
