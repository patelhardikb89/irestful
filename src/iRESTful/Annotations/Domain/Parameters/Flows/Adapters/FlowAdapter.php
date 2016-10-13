<?php
namespace iRESTful\Annotations\Domain\Parameters\Flows\Adapters;
use iRESTful\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;

interface FlowAdapter {
    public function fromConstructorParameterToFlow(ConstructorParameter $constructorParameter);
}
