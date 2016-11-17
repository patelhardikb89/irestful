<?php
namespace iRESTful\Rodson\DSLs\Domain\URLs\Adapters;

interface UrlAdapter {
    public function fromStringToUrl($string);
}
