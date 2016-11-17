<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias;

interface EntitySetRetrieverCriteria {
    public function getContainerName();
    public function hasUuids();
    public function getUuids();
    public function hasKeyname();
    public function getKeyname();
    public function hasOrdering();
    public function getOrdering();
}
