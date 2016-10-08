<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Loop;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\Keyname;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Values\Loops\Keynames\Exceptions\KeynameException;

final class ConcreteClassInstructionValueLoop implements Loop {
    private $keynames;
    public function __construct(array $keynames = null) {

        if (empty($keynames)) {
            $keynames = null;
        }

        if (!empty($keynames)) {
            foreach($keynames as $oneKeyname) {
                throw new KeynameException('The keynames array must only contain Keyname objects.');
            }
        }

        $this->keynames = $keynames;

    }

    public function hasKeynames() {
        return !empty($this->keynames);
    }

    public function getKeynames() {
        return $this->keynames;
    }

}
