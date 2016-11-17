<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\EntityPartialSetRetrieverCriteria;

interface RequestPartialSetAdapter {
    public function fromDataToEntityPartialSetRequest(array $data);
    public function fromDataToEntityPartialSetTotalAmountRequest(array $data);
    public function fromEntityPartialSetRetrieverCriteriaToRequest(EntityPartialSetRetrieverCriteria $criteria);
    public function fromEntityPartialSetRetrieverCriteriaToTotalAmountRequest(EntityPartialSetRetrieverCriteria $criteria);
}
