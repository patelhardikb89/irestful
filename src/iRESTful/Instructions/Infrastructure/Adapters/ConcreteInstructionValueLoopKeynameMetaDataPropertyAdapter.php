<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Adapters\PropertyAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionValueLoopKeynameMetaDataProperty;

final class ConcreteInstructionValueLoopKeynameMetaDataPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }

    public function fromStringToProperty($string) {

        if ($string == 'name') {
            return new ConcreteInstructionValueLoopKeynameMetaDataProperty(true, false);
        }

        if ($string == 'value') {
            return new ConcreteInstructionValueLoopKeynameMetaDataProperty(false, true);
        }

        //throws
    }

}
