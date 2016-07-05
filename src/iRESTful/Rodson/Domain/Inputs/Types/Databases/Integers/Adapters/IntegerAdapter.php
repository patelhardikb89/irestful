<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Integers\Adapters;

interface IntegerAdapter {
    public function fromDataToInteger(array $data);
}
