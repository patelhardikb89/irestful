<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\URLs\Adapters\UrlAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteUrl;

final class ConcreteUrlAdapter implements UrlAdapter {

    public function __construct() {

    }

    public function fromStringToUrl($string) {
        return new ConcreteUrl($string);
    }

}
