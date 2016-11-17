<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Entities\Adapters;

interface EntityAdapter {
    public function fromDataToEntities(array $data);
    public function fromDataToEntity(array $data);
}
