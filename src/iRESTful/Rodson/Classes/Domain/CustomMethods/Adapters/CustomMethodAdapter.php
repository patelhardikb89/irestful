<?php
namespace iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Method;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;

interface CustomMethodAdapter {
    public function fromControllerToCustomMethod(Controller $controller);
    public function fromMethodToCustomMethod(Method $method);
    public function fromTypeToCustomMethod(Type $type);
    public function fromCombosToCustomMethod(array $combos);
}
