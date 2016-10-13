<?php
namespace iRESTful\ClassesValues\Domain\Adapters;
use iRESTful\DSLs\Domain\Projects\Types\Type;

interface ValueAdapter {
    public function fromTypesToValues(array $types);
    public function fromTypeToValue(Type $type);
}
