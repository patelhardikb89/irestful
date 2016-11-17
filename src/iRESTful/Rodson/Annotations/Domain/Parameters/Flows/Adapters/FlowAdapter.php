<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Flows\Adapters;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;

interface FlowAdapter {
    public function fromConstructorParameterToFlow(ConstructorParameter $constructorParameter);
}
