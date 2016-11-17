<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;

interface RequestSetAdapter {
    public function fromDataToEntitySetRequest(array $data);
    public function fromEntitySetRetrieverCriteriaToRequest(EntitySetRetrieverCriteria $criteria);
}
