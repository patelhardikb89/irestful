<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Adapters\PrimitiveAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcretePrimitive;
use iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Exceptions\PrimitiveException;

final class ConcretePrimitiveAdapter implements PrimitiveAdapter {

    public function __construct() {

    }

    public function fromNameToPrimitive($name) {

        $name = strtolower($name);
        if ($name == 'string') {
            return new ConcretePrimitive(true, false, false, false);
        }

        if ($name == 'boolean') {
            return new ConcretePrimitive(false, true, false, false);
        }

        if ($name == 'integer') {
            return new ConcretePrimitive(false, false, true, false);
        }

        if ($name == 'float') {
            return new ConcretePrimitive(false, false, false, true);
        }

        throw new PrimitiveException('The given name ('.$name.') is not a primitive.');
    }

}
