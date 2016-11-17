<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;

interface RequestRelationAdapter {
    public function fromDataToEntityRelationRequest(array $data);
    public function fromEntityRelationRetrieverCriteriaToRequest(EntityRelationRetrieverCriteria $criteria);
}
