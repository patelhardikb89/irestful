<?php
namespace iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Flows\MethodChains\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter as ConstructorParameter;

interface MethodChainAdapter {
    public function fromConstructorParameterToMethodChain(ConstructorParameter $constructorParameter);
}
