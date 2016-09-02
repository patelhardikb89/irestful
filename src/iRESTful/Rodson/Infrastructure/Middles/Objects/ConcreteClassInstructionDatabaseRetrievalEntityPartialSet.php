<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\AnnotatedClass;
use iRESTful\Rodson\Domain\Inputs\Values\Value;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSet implements EntityPartialSet {
    private $annotatedClass;
    private $indexValue;
    private $amountValue;
    public function __construct(AnnotatedClass $annotatedClass, Value $indexValue, Value $amountValue) {
        $this->annotatedClass = $annotatedClass;
        $this->indexValue = $indexValue;
        $this->amountValue = $amountValue;
    }

    public function getAnnotatedClass() {
        return $this->annotatedClass;
    }

    public function getIndexValue() {
        return $this->indexValue;
    }

    public function getAmountValue() {
        return $this->amountValue;
    }

    public function getData() {
        return [
            'class' => $this->getClass()->getData(),
            'value' => [
                'minimum' => $this->getIndexValue(),
                'maximum' => $this->getAmountValue()
            ]
        ];
    }

}
