<?php
namespace iRESTful\Rodson\Domain\Inputs\Projects\Objects\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSample(array $data);
    public function fromDataToSamples(array $data);
}
