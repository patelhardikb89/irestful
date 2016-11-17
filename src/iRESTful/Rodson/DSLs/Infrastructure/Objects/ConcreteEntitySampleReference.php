<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\References\Reference;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Sample;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Properties\Property;

final class ConcreteEntitySampleReference implements Reference {
    private $sample;
    private $property;
    public function __construct(Sample $sample, Property $property) {
        $this->sample = $sample;
        $this->property = $property;
    }

    public function getSample() {
        return $this->sample;
    }

    public function getProperty() {
        return $this->property;
    }

}
