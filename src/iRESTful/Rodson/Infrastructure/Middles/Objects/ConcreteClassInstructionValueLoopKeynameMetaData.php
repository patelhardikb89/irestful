<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\MetaData;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\Properties\Property;

final class ConcreteClassInstructionValueLoopKeynameMetaData implements MetaData {
    private $hasLength;
    private $property;
    public function __construct($hasLength, Property $property = null) {
        $this->hasLength = (bool) $hasLength;
        $this->property = $property;
    }

    public function hasLength() {
        return $this->hasLength;
    }

    public function hasProperty() {
        return !empty($this->property);
    }

    public function getProperty() {
        return $this->property;
    }

}
