<?php
namespace iRESTful\DSLs\Domain\Projects\Objects\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSample(array $data);
    public function fromDataToSamples(array $data);
}
