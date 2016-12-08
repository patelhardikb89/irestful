<?php
namespace iRESTful\Rodson\DSLs\Domain\URLs\Adapters;

interface UrlAdapter {
    public function fromDataToUrl(array $data);
    public function fromStringToUrl($string);
}
