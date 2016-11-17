<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\EntityRelationRetrieverCriteria;

interface RequestRelationAdapter {
    public function fromDataToEntityRelationHttpRequestData(array $data);
    public function fromEntityRelationRetrieverCriteriaToHttpRequestData(EntityRelationRetrieverCriteria $criteria);
}
