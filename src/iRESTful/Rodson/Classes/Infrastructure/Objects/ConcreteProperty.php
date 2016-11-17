<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Objects;
use iRESTful\Rodson\Classes\Domain\Properties\Property;
use iRESTful\Rodson\Classes\Domain\Properties\Exceptions\PropertyException;

final class ConcreteProperty implements Property {
    private $name;
    public function __construct($name) {

        if (empty($name) || !is_string($name)) {
            throw new PropertyException('The name must be a non-empty string.');
        }

        $this->name = $name;

    }

    public function getName() {
        return $this->name;
    }

}
