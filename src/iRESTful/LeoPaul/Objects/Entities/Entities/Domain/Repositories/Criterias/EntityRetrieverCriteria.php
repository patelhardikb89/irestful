<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias;

interface EntityRetrieverCriteria {
    public function getContainerName();
    public function hasUuid();
    public function getUuid();
    public function hasKeyname();
    public function getKeyname();
    public function hasKeynames();
    public function getKeynames();
}
