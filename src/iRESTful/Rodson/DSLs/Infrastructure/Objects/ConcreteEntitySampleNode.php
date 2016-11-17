<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Nodes\SampleNode;

final class ConcreteEntitySampleNode implements SampleNode {
    private $samples;
    public function __construct(array $samples) {
        $this->samples = $samples;
    }

    public function getSamples() {
        return $this->samples;
    }

    public function hasSampleByName(string $name) {
        return isset($this->samples[$name]) && !empty($this->samples[$name]);
    }

    public function getSampleByName(string $name) {

        if (!$this->hasSampleByName($name)) {
            //throws
        }

        return $this->samples[$name];

    }

}
