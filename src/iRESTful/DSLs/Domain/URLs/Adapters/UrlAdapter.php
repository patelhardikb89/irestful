<?php
namespace iRESTful\DSLs\Domain\URLs\Adapters;

interface UrlAdapter {
    public function fromStringToUrl($string);
}
