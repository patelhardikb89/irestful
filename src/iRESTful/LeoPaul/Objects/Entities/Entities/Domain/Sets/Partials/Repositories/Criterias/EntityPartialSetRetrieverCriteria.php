<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Repositories\Criterias;

interface EntityPartialSetRetrieverCriteria {
    public function getContainerName();
    public function getIndex();
    public function getAmount();
    public function hasOrdering();
    public function getOrdering();
}
