<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Objects;
use iRESTful\Rodson\Classes\Domain\Samples\Sample;
use iRESTful\Rodson\Classes\Domain\Samples\Exceptions\SampleException;

final class ConcreteSample implements Sample {
    private $container;
    private $data;
    public function __construct($container, array $data) {

        if (empty($container) || !is_string($container)) {
            throw new SampleException('The container must be a non-empty string.');
        }

        if (empty($data)) {
            throw new SampleException('The data cannot be empty.');
        }

        $this->container = $container;
        $this->data = $data;

    }

    public function getContainerName() {
        return $this->container;
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
