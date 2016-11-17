<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;

interface RequestPartialSetAdapter {
    public function fromDataToEntityPartialSetHttpRequestData(array $data);
    public function fromEntityPartialSetRetrieverCriteriaToHttpRequestData(EntityPartialSetRetrieverCriteria $criteria);
}
