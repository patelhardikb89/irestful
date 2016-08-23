<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Urls;

interface Url {
    public function getBaseUrl();
    public function getEndpoint();
    public function hasPort();
    public function getPort();
    public function getData();
}
