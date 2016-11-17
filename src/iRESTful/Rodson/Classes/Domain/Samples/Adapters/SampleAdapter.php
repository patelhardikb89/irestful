<?php
namespace iRESTful\Rodson\Classes\Domain\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSamples(array $data);
    public function fromDataToSample(array $data);
}
