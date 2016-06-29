<?php
namespace iRESTful\Rodson\Domain\Types\Databases\Integers\Adapters;

interface IntegerAdapter {
    public function fromDataToInteger(array $data);
}
