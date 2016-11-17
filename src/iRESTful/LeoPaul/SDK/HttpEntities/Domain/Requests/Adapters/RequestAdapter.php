<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;

interface RequestAdapter {
    public function fromDataToEntityHttpRequestData(array $data);
    public function fromEntityRetrieverCriteriaToHttpRequestData(EntityRetrieverCriteria $criteria);
}
