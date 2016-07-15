<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Property;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Exceptions\PropertyException;

final class ConcreteClassProperty implements Property {
    private $name;
    public function __construct($name) {

        if (empty($name) || !is_string($name)) {
            throw new PropertyException('The name must be a non-empty string.');
        }

        $this->name = $name;

    }

    public function get() {
        return $this->name;
    }

}
