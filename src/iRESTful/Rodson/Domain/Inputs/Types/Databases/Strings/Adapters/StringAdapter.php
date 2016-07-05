<?php
namespace iRESTful\Rodson\Domain\Inputs\Types\Databases\Strings\Adapters;

interface StringAdapter {
    public function fromDataToString(array $data);
}
