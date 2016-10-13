<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Adapters\KeynameAdapter;

final class ConcreteInstructionValueLoopAdapter implements LoopAdapter {
    private $keynameAdapter;
    public function __construct(KeynameAdapter $keynameAdapter) {
        $this->keynameAdapter = $keynameAdapter;
    }

    public function fromStringToLoop($string) {
        print_r(['fromStringToLoop']);
        die();
    }

}
