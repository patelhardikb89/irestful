<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;

interface ParameterAdapter {
    public function fromClassToParameters(ObjectClass $class);
}
