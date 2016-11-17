<?php
namespace iRESTful\Rodson\ClassesValues\Domain\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;

interface ValueAdapter {
    public function fromTypesToValues(array $types);
    public function fromTypeToValue(Type $type);
}
