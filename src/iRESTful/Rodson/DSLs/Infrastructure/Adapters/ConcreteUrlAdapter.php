<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\URLs\Adapters\UrlAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteUrl;

final class ConcreteUrlAdapter implements UrlAdapter {

    public function __construct() {

    }

    public function fromDataToUrl(array $data) {
        $output = [];
        foreach($data as $keyname => $string) {
            $output[$keyname] = $this->fromStringToUrl($string);
        }

        return $output;
    }

    public function fromStringToUrl($string) {
        return new ConcreteUrl($string);
    }

}
