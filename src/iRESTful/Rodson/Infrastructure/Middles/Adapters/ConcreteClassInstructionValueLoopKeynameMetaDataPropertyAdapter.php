<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\Properties\Adapters\PropertyAdapter;

final class ConcreteClassInstructionValueLoopKeynameMetaDataPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }

    public function fromStringToProperty($string) {
        print_r(['fromStringToProperty']);
        die();
    }

}
