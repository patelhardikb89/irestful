<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Adapters;

interface TypeAdapter {
    public function fromDataToType(array $data);
}
