<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassProperty;

final class ConcreteClassPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }

    public function fromNameToProperty($name) {
        return new ConcreteClassProperty($name);
    }

}
