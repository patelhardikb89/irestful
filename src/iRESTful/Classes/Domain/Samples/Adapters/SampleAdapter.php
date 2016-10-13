<?php
namespace iRESTful\Classes\Domain\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSamples(array $data);
    public function fromDataToSample(array $data);
}
