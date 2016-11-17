<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias\Adapters;

interface EntityPartialSetRetrieverCriteriaAdapter {
    public function fromDataToEntityPartialSetRetrieverCriteria(array $data);
}
