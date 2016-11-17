<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Types\Adapters;

interface TypeAdapter {
    public function fromDataToType(array $data);
}
