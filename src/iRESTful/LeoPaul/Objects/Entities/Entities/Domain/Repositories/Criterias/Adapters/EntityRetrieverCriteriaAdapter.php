<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters;

interface EntityRetrieverCriteriaAdapter {
    public function fromDataToRetrieverCriteria(array $data);
}
