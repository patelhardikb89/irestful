<?php
namespace iRESTful\ClassesTests\Domain\Transforms\Adapters;

interface TransformAdapter {
    public function fromDataToTransforms(array $data);
}
