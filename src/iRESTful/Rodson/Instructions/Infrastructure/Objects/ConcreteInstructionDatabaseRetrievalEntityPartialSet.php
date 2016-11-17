<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Instructions\Domain\Containers\Container;
use iRESTful\Rodson\Instructions\Domain\Values\Value;

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
