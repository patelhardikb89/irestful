<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\Properties\Property;

final class ConcreteClassInstructionValueLoopKeynameMetaDataProperty implements Property {
    private $isName;
    private $isValue;
    public function __construct($isName, $isValue) {
        $this->isName = (bool) $isName;
        $this->isValue = (bool) $isValue;
    }

    public function isName() {
        return $this->isName;
    }

    public function isValue() {
        return $this->isValue;
    }

}
