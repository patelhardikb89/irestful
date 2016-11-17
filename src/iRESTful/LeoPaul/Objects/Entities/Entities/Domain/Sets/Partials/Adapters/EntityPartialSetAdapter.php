<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Partials\EntityPartialSet;

interface EntityPartialSetAdapter {
    public function fromDataToEntityPartialSet(array $data);
    public function fromEntityPartialSetToData(EntityPartialSet $entityPartialSet);
}
