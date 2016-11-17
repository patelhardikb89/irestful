<?php
namespace iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Method;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;

interface CustomMethodAdapter {
    public function fromControllerInstructionsToCustomMethod(array $instructions);
    public function fromObjectToCustomMethods(Object $object);
    public function fromMethodsToCustomMethods(array $methods);
    public function fromMethodToCustomMethod(Method $method);
    public function fromTypeToCustomMethod(Type $type);
}
