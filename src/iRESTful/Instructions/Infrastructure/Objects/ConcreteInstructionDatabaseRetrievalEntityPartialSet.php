<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Instructions\Domain\Containers\Container;
use iRESTful\DSLs\Domain\Projects\Values\Value;

final class ConcreteInstructionDatabaseRetrievalEntityPartialSet implements EntityPartialSet {
    private $container;
    private $indexValue;
    private $amountValue;
    public function __construct(Container $container, Value $indexValue, Value $amountValue) {
        $this->container = $container;
        $this->indexValue = $indexValue;
        $this->amountValue = $amountValue;
    }

    public function getContainer() {
        return $this->container;
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
