<?php
namespace iRESTful\ClassesConverters\Domain\Methods\Adapters;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
}
