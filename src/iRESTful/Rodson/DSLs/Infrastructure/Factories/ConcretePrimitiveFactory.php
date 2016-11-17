<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Factories;
use iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Factories\PrimitiveFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcretePrimitive;

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
