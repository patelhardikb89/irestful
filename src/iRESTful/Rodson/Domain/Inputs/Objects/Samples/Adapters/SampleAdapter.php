<?php
namespace iRESTful\Rodson\Domain\Inputs\Objects\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSample(array $data);
    public function fromDataToSamples(array $data);
}
