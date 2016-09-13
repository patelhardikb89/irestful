<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Container;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Value;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSet implements EntityPartialSet {
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
