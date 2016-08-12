<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Keyname;
use iRESTful\Rodson\Domain\Inputs\Values\Value;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Exceptions\KeynameException;

final class ConcreteClassInstructionDatabaseRetrievalKeyname implements Keyname {
    private $name;
    private $value;
    public function __construct($name, Value $value) {

        if (empty($name) || !is_string($name)) {
            throw new KeynameException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->value = $value;

    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

}
