<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalKeyname;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Exceptions\KeynameException;

final class ConcreteClassInstructionDatabaseRetrievalKeynameAdapter implements KeynameAdapter {
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

        $value = $this->valueAdapter->fromStringToValue($data['value']);
        return new ConcreteClassInstructionDatabaseRetrievalKeyname($data['name'], $value);
    }

}
