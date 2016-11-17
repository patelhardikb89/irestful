<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\Adapters;

interface SampleNodeAdapter {
    public function fromDataToSampleNode(array $data);
}
