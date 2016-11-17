<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias;

interface EntityRelationRetrieverCriteria {
    public function getMasterContainerName();
    public function getSlaveContainerName();
    public function getSlavePropertyName();
    public function getMasterUuid();
}
