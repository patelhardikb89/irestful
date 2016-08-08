<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Samples\Adapters\SampleAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSample;
use iRESTful\Rodson\Domain\Middles\Samples\Exceptions\SampleException;

final class ConcreteSampleAdapter implements SampleAdapter {

    public function __construct() {

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
