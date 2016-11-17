<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Values\Loops\Keynames\MetaDatas\MetaData;
use iRESTful\Rodson\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Property;

final class ConcreteInstructionValueLoopKeynameMetaData implements MetaData {
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
