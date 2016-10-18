<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Values\Loops\Adapters\LoopAdapter;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Adapters\KeynameAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionValueLoop;

final class ConcreteInstructionValueLoopAdapter implements LoopAdapter {
    private $keynameAdapter;
    public function __construct(KeynameAdapter $keynameAdapter) {
        $this->keynameAdapter = $keynameAdapter;
    }

    public function fromStringToLoop($string) {
        $keynames = [];
        $exploded = explode('->', $string);
        foreach($exploded as $oneKeyname) {
            if ($oneKeyname == '$each') {
                continue;
            }

            $keynames[] = $this->keynameAdapter->fromStringToKeyname($oneKeyname);
        }

        return new ConcreteInstructionValueLoop($keynames);
    }

}
