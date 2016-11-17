<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\RelatedEntity;
use iRESTful\Rodson\Instructions\Domain\Containers\Container;
use iRESTful\Rodson\Instructions\Domain\Values\Value;

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
