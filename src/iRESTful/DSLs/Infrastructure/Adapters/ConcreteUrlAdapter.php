<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\URLs\Adapters\UrlAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteUrl;

final class ConcreteUrlAdapter implements UrlAdapter {

    public function __construct() {

    }

    public function fromStringToUrl($string) {
        return new ConcreteUrl($string);
    }

}
