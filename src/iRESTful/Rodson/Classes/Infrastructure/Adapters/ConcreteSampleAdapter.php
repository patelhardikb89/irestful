<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Adapters;
use iRESTful\Rodson\Classes\Domain\Samples\Adapters\SampleAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteSample;
use iRESTful\Rodson\Classes\Domain\Samples\Exceptions\SampleException;

final class ConcreteSampleAdapter implements SampleAdapter {

    public function __construct() {

    }

    public function fromDataToSamples(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToSample($oneData);
        }

        return $output;
    }

    public function fromDataToSample(array $data) {

        if (!isset($data['container'])) {
            throw new SampleException('The container keyname is mandatory in order to convert data to a Sample object.');
        }

        if (!isset($data['data'])) {
            throw new SampleException('The data keyname is mandatory in order to convert data to a Sample object.');
        }
        
        return new ConcreteSample($data['container'], $data['data']);

    }

}
