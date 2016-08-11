<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Adapters\InputAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInput;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

final class ConcreteClassInputAdapter implements InputAdapter {

    public function __construct() {

    }

    public function fromControllerToInput(Controller $controller) {
        return new ConcreteClassInput(null, null, $controller);
    }

    public function fromObjectToInput(Object $object) {
        return new ConcreteClassInput($object);
    }

    public function fromTypeToInput(Type $type) {
        return new ConcreteClassInput(null, $type);
    }

}
