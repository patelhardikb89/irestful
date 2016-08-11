<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests;

interface HttpRequest {
    public function getCommand();
    public function getView();
    public function hasQueryParameters();
    public function getQueryParameters();
    public function hasRequestParameters();
    public function getRequestParameters();
    public function hasHeaders();
    public function getHeaders();
}
