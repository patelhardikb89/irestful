<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Inputs\Values\Value;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSet implements EntityPartialSet {
    private $class;
    private $minimumValue;
    private $maximumValue;
    public function __construct(ObjectClass $class, Value $minimumValue, Value $maximumValue) {
        $this->class = $class;
        $this->minimumValue = $minimumValue;
        $this->maximumValue = $maximumValue;
    }

    public function getClass() {
        return $this->class;
    }

    public function getMinimumValue() {
        return $this->minimumValue;
    }

    public function getMaximumValue() {
        return $this->maximumValue;
    }

    public function getData() {
        return [
            'class' => $this->getClass()->getData(),
            'value' => [
                'minimum' => $this->getMinimumValue(),
                'maximum' => $this->getMaximumValue()
            ]
        ];
    }

}
