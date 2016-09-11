<?php
namespace iRESTful\Rodson\Domain\Middles\Classes\Types\Tests\Transforms\Adapters;

interface TransformAdapter {
    public function fromDataToTransforms(array $data);
}
