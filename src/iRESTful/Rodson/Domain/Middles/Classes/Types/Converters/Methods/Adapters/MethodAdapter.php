<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Methods\Adapters;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
}
