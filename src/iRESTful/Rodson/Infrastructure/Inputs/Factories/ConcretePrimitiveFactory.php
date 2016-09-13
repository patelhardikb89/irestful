<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Factories;
use iRESTful\Rodson\Domain\Inputs\Projects\Primitives\Factories\PrimitiveFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcretePrimitive;

final class ConcretePrimitiveFactory implements PrimitiveFactory {

    public function __construct() {

    }

    public function createAll() {
        return [
            'string' => new ConcretePrimitive(true, false, false, false),
            'boolean' => new ConcretePrimitive(false, true, false, false),
            'integer' => new ConcretePrimitive(false, false, true, false),
            'float' => new ConcretePrimitive(false, false, false, true)
        ];
    }

}
