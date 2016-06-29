<?php
namespace iRESTful\Rodson\Domain\Types\Databases\Strings\Adapters;

interface StringAdapter {
    public function fromDataToString(array $data);
}
