<?php
namespace iRESTful\Rodson\Domain\Inputs\Controllers\HttpRequests\Commands\Urls\Adapters;

interface UrlAdapter {
    public function fromStringToUrl($string);
}
