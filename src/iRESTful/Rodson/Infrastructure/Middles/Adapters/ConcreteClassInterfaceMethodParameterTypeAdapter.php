<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInterfaceMethodParameterType;

final class ConcreteClassInterfaceMethodParameterTypeAdapter implements TypeAdapter {

    public function __construct() {

    }

    public function fromDataToType(array $data) {

        $isArray = false;
        if (isset($data['is_array'])) {
            $isArray = (bool) $data['is_array'];
        }

        $namespace = null;
        if (isset($data['namespace'])) {
            $namespace = $data['namespace'];
        }

        $primitive = null;
        if (isset($data['primitive'])) {
            $primitive = $data['primitive'];
        }

        return new ConcreteClassInterfaceMethodParameterType($isArray, $namespace, $primitive);

    }

}
