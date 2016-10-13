<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Databases\Retrievals\Keynames\Keyname;
use iRESTful\DSLs\Domain\Projects\Values\Value;

final class ConcreteInstructionDatabaseRetrievalKeyname implements Keyname {
    private $name;
    private $value;
    public function __construct(Value $name, Value $value) {
        $this->name = $name;
        $this->value = $value;

    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getData() {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue()->getData()
        ];
    }

}
