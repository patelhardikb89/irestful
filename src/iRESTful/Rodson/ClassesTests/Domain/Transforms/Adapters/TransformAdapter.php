<?php
namespace iRESTful\Rodson\ClassesTests\Domain\Transforms\Adapters;

interface TransformAdapter {
    public function fromDataToTransforms(array $data);
}
