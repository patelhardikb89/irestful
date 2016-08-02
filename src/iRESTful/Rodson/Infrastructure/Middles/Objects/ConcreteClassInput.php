<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Input;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Exceptions\InputException;

final class ConcreteClassInput implements Input {
    private $object;
    private $type;
    public function __construct(Object $object = null, Type $type = null) {

        $amount = (empty($object) ? 0 : 1) + (empty($type) ? 0 : 1);
        if ($amount != 1) {
            throw new InputException('There must be either an Object or a Type.  '.$amount.' given.');
        }

        $this->object = $object;
        $this->type = $type;

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

}
