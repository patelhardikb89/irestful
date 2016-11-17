<?php
namespace iRESTful\Rodson\ClassesConverters\Domain\Methods\Adapters;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
}
