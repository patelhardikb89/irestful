<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Adapters\MetaDataAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Adapters\PropertyAdapter;

final class ConcreteInstructionValueLoopKeynameMetaData implements MetaDataAdapter {
    private $propertyAdapter;
    public function __construct(PropertyAdapter $propertyAdapter) {
        $this->propertyAdapter = $propertyAdapter;
    }

    public function fromStringToMetaData($string) {
        print_r(['fromStringToMetaData']);
        die();
    }

}
