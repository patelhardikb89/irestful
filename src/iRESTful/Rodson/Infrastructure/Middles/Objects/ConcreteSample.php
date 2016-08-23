<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Samples\Sample;
use iRESTful\Rodson\Domain\Middles\Samples\Exceptions\SampleException;

final class ConcreteSample implements Sample {
    private $containerName;
    private $data;
    public function __construct($containerName, array $data) {

        if (empty($containerName) || !is_string($containerName)) {
            throw new SampleException('The containerName must be a non-empty string.');
        }

        if (empty($data)) {
            throw new SampleException('The data cannot be empty.');
        }

        $this->containerName = $containerName;
        $this->data = $data;

    }

    public function getContainerName() {
        return $this->containerName;
    }

    public function getSampleData() {
        return $this->data;
    }

    public function getData() {
        return [
            'container' => $this->getContainerName(),
            'data' => $this->getSampleData()
        ];
    }

}
