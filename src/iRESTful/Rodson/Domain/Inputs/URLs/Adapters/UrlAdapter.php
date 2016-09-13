<?php
namespace iRESTful\Rodson\Domain\Inputs\URLs\Adapters;

interface UrlAdapter {
    public function fromStringToUrl($string);
}
