<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\Adapters\KeynameAdapter;

final class ConcreteClassInstructionValueLoopAdapter implements LoopAdapter {
    private $keynameAdapter;
    public function __construct(KeynameAdapter $keynameAdapter) {
        $this->keynameAdapter = $keynameAdapter;
    }

    public function fromStringToLoop($string) {
        print_r(['fromStringToLoop']);
        die();
    }

}
