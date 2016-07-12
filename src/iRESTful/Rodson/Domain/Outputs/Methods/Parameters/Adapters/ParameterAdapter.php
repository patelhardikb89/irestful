<?php
namespace iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Type;

interface ParameterAdapter {
    public function fromTypeToParameter(Type $type);
}
