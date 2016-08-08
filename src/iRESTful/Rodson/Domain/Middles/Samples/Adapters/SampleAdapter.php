<?php
namespace iRESTful\Rodson\Domain\Middles\Samples\Adapters;

interface SampleAdapter {
    public function fromDataToSample(array $data);
}
