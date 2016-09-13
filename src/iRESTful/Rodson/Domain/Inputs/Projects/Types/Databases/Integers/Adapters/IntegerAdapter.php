<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Integers\Adapters;

interface IntegerAdapter {
    public function fromDataToInteger(array $data);
}
