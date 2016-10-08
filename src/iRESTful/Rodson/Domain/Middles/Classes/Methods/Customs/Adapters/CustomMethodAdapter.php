<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;

interface CustomMethodAdapter {
    public function fromControllerInstructionsToCustomMethod(array $instructions);
    public function fromTestInstructionsToCustomMethods(array $testInstructions);
    public function fromObjectToCustomMethods(Object $object);
    public function fromMethodsToCustomMethods(array $methods);
    public function fromMethodToCustomMethod(Method $method);
    public function fromTypeToCustomMethod(Type $type);
}
