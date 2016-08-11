<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Input;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Exceptions\InputException;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;

final class ConcreteClassInput implements Input {
    private $object;
    private $type;
    private $controller;
    public function __construct(Object $object = null, Type $type = null, Controller $controller = null) {

        $amount = (empty($object) ? 0 : 1) + (empty($type) ? 0 : 1) + (empty($controller) ? 0 : 1);
        if ($amount != 1) {
            throw new InputException('There must be either a Controller, an Object or a Type.  '.$amount.' given.');
        }

        $this->object = $object;
        $this->type = $type;
        $this->controller = $controller;
    }

    public function hasType() {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }

    public function hasObject() {
        return !empty($this->object);
    }

    public function getObject() {
        return $this->object;
    }

    public function hasController() {
        return !empty($this->controller);
    }

    public function getController() {
        return $this->controller;
    }

}
