<?php
namespace iRESTful\Rodson\Domain\Repositories\Criterias\Adapters;

interface RodsonRetrieverCriteriaAdapter {
    public function fromDataToRodsonRetrieverCriteria(array $data);
}
