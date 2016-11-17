<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseRetrievalKeyname;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Keynames\Exceptions\KeynameException;

final class ConcreteInstructionDatabaseRetrievalKeynameAdapter implements KeynameAdapter {
    private $valueAdapter;
    public function __construct(ValueAdapter $valueAdapter) {
        $this->valueAdapter = $valueAdapter;
    }

    public function fromDataToKeyname(array $data) {

        if (!isset($data['name'])) {
            throw new KeynameException('The name keyname is mandatory in order to convert data to a Keyname object.');
        }

        if (!isset($data['value'])) {
            throw new KeynameException('The value keyname is mandatory in order to convert data to a Keyname object.');
        }

        $name = $this->valueAdapter->fromStringToValue($data['name']);
        $value = $this->valueAdapter->fromStringToValue($data['value']);
        return new ConcreteInstructionDatabaseRetrievalKeyname($name, $value);
    }

}
