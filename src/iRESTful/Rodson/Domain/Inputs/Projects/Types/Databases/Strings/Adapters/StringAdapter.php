<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\Adapters;

interface StringAdapter {
    public function fromDataToString(array $data);
}
