<?php
namespace iRESTful\Annotations\Domain\Parameters\Flows\MethodChains\Adapters;
use iRESTful\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;

interface MethodChainAdapter {
    public function fromConstructorParameterToMethodChain(ConstructorParameter $constructorParameter);
}
