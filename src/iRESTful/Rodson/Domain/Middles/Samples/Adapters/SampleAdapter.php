<?php
namespace iRESTful\Rodson\Domain\Middles\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSamples(array $data);
    public function fromDataToSample(array $data);
}
