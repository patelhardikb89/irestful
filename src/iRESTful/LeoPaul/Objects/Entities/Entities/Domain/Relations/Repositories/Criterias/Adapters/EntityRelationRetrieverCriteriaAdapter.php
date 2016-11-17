<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters;

interface EntityRelationRetrieverCriteriaAdapter {
    public function fromDataToEntityRelationRetrieverCriteria(array $data);
}
