<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;

interface RequestSetAdapter {
    public function fromDataToEntitySetHttpRequestData(array $data);
    public function fromEntitySetRetrieverCriteriaToHttpRequestData(EntitySetRetrieverCriteria $criteria);
}
