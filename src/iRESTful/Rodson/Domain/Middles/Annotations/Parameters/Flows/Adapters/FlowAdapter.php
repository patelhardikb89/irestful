<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;

interface FlowAdapter {
    public function fromConstructorParameterToFlow(ConstructorParameter $constructorParameter);
}
