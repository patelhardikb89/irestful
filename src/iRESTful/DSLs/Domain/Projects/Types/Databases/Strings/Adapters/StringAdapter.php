<?php
namespace iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\Adapters;

interface StringAdapter {
    public function fromDataToString(array $data);
}
