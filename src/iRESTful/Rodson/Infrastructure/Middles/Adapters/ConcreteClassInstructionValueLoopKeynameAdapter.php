<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\Adapters\KeynameAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\MetaDatas\Adapters\MetaDataAdapter;

final class ConcreteClassInstructionValueLoopKeynameAdapter implements KeynameAdapter {
    private $metaDataAdapter;
    public function __construct(MetaDataAdapter $metaDataAdapter) {
        $this->metaDataAdapter = $metaDataAdapter;
    }

    public function fromStringToKeyname($string) {
        print_r(['fromStringToKeyname']);
        die();
    }

}
