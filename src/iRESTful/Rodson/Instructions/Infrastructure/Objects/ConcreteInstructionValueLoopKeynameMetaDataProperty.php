<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Property;

final class ConcreteInstructionValueLoopKeynameMetaDataProperty implements Property {
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
