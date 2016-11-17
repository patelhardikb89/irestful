<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Controllers\HttpRequests\Commands\Urls\Adapters;

interface UrlAdapter {
    public function fromStringToUrl($string);
}
