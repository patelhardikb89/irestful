<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\URLs\Url;

final class ConcreteUrl implements Url {
    private $url;
    public function __construct($url) {
        $this->url = $url;
    }

    public function get() {
        return $this->url;
    }

}
