<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Properties\Adapters\PropertyAdapter;

final class ConcreteInstructionValueLoopKeynameMetaDataPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }

    public function fromStringToProperty($string) {
        print_r(['fromStringToProperty']);
        die();
    }

}
