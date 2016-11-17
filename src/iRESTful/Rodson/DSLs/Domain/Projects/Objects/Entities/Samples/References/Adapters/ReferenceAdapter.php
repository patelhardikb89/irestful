<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\References\Adapters;

interface ReferenceAdapter {
    public function fromDataToReferences(array $data);
}
