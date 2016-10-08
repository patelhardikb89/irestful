<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\Adapters\MetaDataAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\Properties\Adapters\PropertyAdapter;

final class ConcreteClassInstructionValueLoopKeynameMetaData implements MetaDataAdapter {
    private $propertyAdapter;
    public function __construct(PropertyAdapter $propertyAdapter) {
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromStringToMetaData($string) {
        print_r(['fromStringToMetaData']);
        die();
    }

}
