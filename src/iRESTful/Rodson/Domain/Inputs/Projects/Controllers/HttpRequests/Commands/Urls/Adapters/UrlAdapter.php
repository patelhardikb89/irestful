<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Controllers\HttpRequests\Commands\Urls\Adapters;

interface UrlAdapter {
    public function fromStringToUrl($string);
}
