<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Objects\Methods\Adapters;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
    public function fromDataToMethod(array $data);
}
