<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

interface CustomMethodAdapter {
    public function fromInstructionsToCustomMethod(array $instructions);
    public function fromObjectToCustomMethods(Object $object);
    public function fromTypeToCustomMethod(Type $type);
    public function fromTypeToAdapterCustomMethods(Type $type);
    public function fromMethodsToCustomMethods(array $methods);
    public function fromMethodToCustomMethod(Method $method);
}
