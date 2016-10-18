<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Values\Loops\Loop;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Keyname;
use iRESTful\Instructions\Domain\Values\Loops\Keynames\Exceptions\KeynameException;

final class ConcreteInstructionValueLoop implements Loop {
    private $keynames;
    public function __construct(array $keynames = null) {

        if (empty($keynames)) {
            $keynames = null;
        }

        if (!empty($keynames)) {
            foreach($keynames as $oneKeyname) {
                if (!($oneKeyname instanceof Keyname)) {
                    throw new KeynameException('The keynames array must only contain Keyname objects.');
                }
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
