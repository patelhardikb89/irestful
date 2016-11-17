<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Integers\Adapters;

interface IntegerAdapter {
    public function fromDataToInteger(array $data);
}
