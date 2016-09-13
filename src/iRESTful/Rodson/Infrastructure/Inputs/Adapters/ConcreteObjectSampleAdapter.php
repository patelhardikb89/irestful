<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Samples\Adapters\SampleAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteObjectSample;

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
