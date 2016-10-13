<?php
namespace iRESTful\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls;

interface Url {
    public function getBaseUrl();
    public function getEndpoint();
    public function hasPort();
    public function getPort();
}
