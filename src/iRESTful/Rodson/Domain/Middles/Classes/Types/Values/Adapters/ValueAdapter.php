<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface ValueAdapter {
    public function fromTypesToValues(array $types);
    public function fromTypeToValue(Type $type);
}
