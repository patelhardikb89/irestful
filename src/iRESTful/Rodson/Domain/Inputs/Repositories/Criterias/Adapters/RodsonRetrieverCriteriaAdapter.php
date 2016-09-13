<?php
namespace iRESTful\Rodson\Domain\Inputs\Repositories\Criterias\Adapters;

interface RodsonRetrieverCriteriaAdapter {
    public function fromFilePathToRodsonRetrieverCriteria($filePath);
}
