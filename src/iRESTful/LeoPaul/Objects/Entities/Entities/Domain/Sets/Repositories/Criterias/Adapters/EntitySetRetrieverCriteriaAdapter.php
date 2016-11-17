<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\Adapters;

interface EntitySetRetrieverCriteriaAdapter {
    public function fromDataToEntitySetRetrieverCriteria(array $data);
}
