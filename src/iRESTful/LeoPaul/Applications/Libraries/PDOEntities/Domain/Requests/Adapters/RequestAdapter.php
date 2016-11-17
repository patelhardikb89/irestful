<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;

interface RequestAdapter {
    public function fromDataToEntityRequest(array $data);
    public function fromEntityRetrieverCriteriaToRequest(EntityRetrieverCriteria $criteria);
}
