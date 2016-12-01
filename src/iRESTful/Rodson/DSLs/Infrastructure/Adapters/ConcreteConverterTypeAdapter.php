<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Primitives\Primitive;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteConverterType;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Exceptions\TypeException;

final class ConcreteConverterTypeAdapter implements TypeAdapter {

    public function __construct() {

    }

    public function fromTypeToAdapterType(Type $type) {
        return new ConcreteConverterType(false, null, $type);
    }

    public function fromPrimitiveToAdapterType(Primitive $primitive) {
        return new ConcreteConverterType(false, $primitive);
    }

    public function fromStringToAdapterType(string $string) {

        if (($string == 'data') || ($string == 'input')) {
            return new ConcreteConverterType(true);
        }

        return new ConcreteConverterType(false, null, null, $string);

    }

}
