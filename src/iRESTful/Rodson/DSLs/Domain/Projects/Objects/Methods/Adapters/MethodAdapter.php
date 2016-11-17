<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Adapters;

interface MethodAdapter {
    public function fromDataToMethods(array $data);
    public function fromDataToMethod(array $data);
}
