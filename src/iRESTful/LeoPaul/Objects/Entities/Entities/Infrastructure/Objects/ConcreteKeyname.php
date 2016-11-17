<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;

final class ConcreteKeyname implements Keyname {
    private $keyname;
    private $value;
    public function __construct($keyname, $value) {

        if (!is_string($keyname) || empty($keyname)) {
            throw new KeynameException('The keyname ('.$keyname.') must be a non-empty string.');
        }

        if (is_object($value)) {
            throw new KeynameException('The value ('.$keyname.') cannot be an object.');
        }

        if (is_array($value)) {
            throw new KeynameException('The value ('.$keyname.') cannot be an array.');
        }

        if (is_null($value)) {
            throw new KeynameException('The value ('.$keyname.') cannot be empty.');
        }

        $this->keyname = $keyname;
        $this->value = $value;
    }

    public function getName() {
        return $this->keyname;
    }

    public function getValue() {
        return $this->value;
    }

}
