<?php
namespace iRESTful\Rodson\Annotations\Domain\Parameters\Flows\MethodChains\Adapters;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;

interface MethodChainAdapter {
    public function fromConstructorParameterToMethodChain(ConstructorParameter $constructorParameter);
}
