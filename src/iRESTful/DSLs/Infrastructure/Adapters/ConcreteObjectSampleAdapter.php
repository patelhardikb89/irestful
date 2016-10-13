<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Samples\Adapters\SampleAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteObjectSample;

final class ConcreteObjectSampleAdapter implements SampleAdapter {

    public function __construct() {

    }

    public function fromDataToSample(array $data) {
        return new ConcreteObjectSample($data);
    }

    public function fromDataToSamples(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToSample($oneData);
        }

        return $output;
    }

}
