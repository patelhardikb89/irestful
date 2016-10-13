<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Adapters\KeynameAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\MetaDatas\Adapters\MetaDataAdapter;

final class ConcreteInstructionValueLoopKeynameAdapter implements KeynameAdapter {
    private $metaDataAdapter;
    public function __construct(MetaDataAdapter $metaDataAdapter) {
        $this->metaDataAdapter = $metaDataAdapter;
    }

    public function fromStringToKeyname($string) {
        print_r(['fromStringToKeyname']);
        die();
    }

}
