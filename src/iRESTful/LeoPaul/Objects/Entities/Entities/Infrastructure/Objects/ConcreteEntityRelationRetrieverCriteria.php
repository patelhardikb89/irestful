<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

final class ConcreteEntityRelationRetrieverCriteria implements EntityRelationRetrieverCriteria {
    private $masterContainerName;
    private $slaveContainerName;
    private $slavePropertyName;
    private $masterUuid;
    public function __construct($masterContainerName, $slaveContainerName, $slavePropertyName, Uuid $masterUuid) {

        if (!is_string($masterContainerName) || empty($masterContainerName)) {
            throw new EntityRelationException('The masterContainerName must be a non-empty string.');
        }

        if (!is_string($slaveContainerName) || empty($slaveContainerName)) {
            throw new EntityRelationException('The slaveContainerName must be a non-empty string.');
        }

        if (!is_string($slavePropertyName) || empty($slavePropertyName)) {
            throw new EntityRelationException('The slavePropertyName must be a non-empty string.');
        }

        $this->masterContainerName = $masterContainerName;
        $this->slaveContainerName = $slaveContainerName;
        $this->slavePropertyName = $slavePropertyName;
        $this->masterUuid = $masterUuid;

    }

    public function getMasterContainerName() {
        return $this->masterContainerName;
    }

    public function getSlaveContainerName() {
        return $this->slaveContainerName;
    }

    public function getSlavePropertyName() {
        return $this->slavePropertyName;
    }

    public function getMasterUuid() {
        return $this->masterUuid;
    }

}
