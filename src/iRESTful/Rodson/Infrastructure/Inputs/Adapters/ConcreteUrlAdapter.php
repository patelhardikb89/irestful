<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\URLs\Adapters\UrlAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteUrl;

final class ConcreteUrlAdapter implements UrlAdapter {

    public function __construct() {

    }

    public function fromStringToUrl($string) {
        return new ConcreteUrl($string);
    }

}
