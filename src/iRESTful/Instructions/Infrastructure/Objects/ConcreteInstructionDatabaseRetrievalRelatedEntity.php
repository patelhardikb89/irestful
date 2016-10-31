<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Databases\Retrievals\Relations\RelatedEntity;
use iRESTful\Instructions\Domain\Containers\Container;
use iRESTful\Instructions\Domain\Values\Value;

final class ConcreteInstructionDatabaseRetrievalRelatedEntity implements RelatedEntity {
    private $masterContainer;
    private $masterUuidValue;
    private $slavePropertyValue;
    private $slaveContainer;
    public function __construct(Container $masterContainer, Value $masterUuidValue, Value $slavePropertyValue, Container $slaveContainer) {
        $this->masterContainer = $masterContainer;
        $this->masterUuidValue = $masterUuidValue;
        $this->slavePropertyValue = $slavePropertyValue;
        $this->slaveContainer = $slaveContainer;
    }

    public function getMasterContainer() {
        return $this->masterContainer;
    }

    public function getMasterUuidValue() {
        return $this->masterUuidValue;
    }

    public function getSlavePropertyValue() {
        return $this->slavePropertyValue;
    }

    public function getSlaveContainer() {
        return $this->slaveContainer;
    }

}
