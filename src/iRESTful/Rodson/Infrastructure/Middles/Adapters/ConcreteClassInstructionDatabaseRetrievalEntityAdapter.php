<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Entities\Exceptions\EntityException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\ContainerAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityAdapter implements EntityAdapter {
    private $keynameAdapter;
    private $valueAdapter;
    private $containerAdapter;
    public function __construct(KeynameAdapter $keynameAdapter, ValueAdapter $valueAdapter, ContainerAdapter $containerAdapter) {
        $this->keynameAdapter = $keynameAdapter;
        $this->valueAdapter = $valueAdapter;
        $this->containerAdapter = $containerAdapter;
    }

    public function fromDataToEntity(array $data) {

        if (!isset($data['object_name'])) {
            throw new EntityException('The object_name keyname is mandatory in order to convert data to an Entity object.');
        }

        if (!isset($data['property']) || !isset($data['property']['name'])) {
            throw new EntityException('The property->name keyname is mandatory in order to convert data to an Entity object.');
        }

        if (!isset($data['property']['value'])) {
            throw new EntityException('The property->value keyname is mandatory in order to convert data to an Entity object.');
        }

        if ($data['property']['name'] == 'uuid') {
            $value = $this->valueAdapter->fromStringToValue($data['property']['value']);
            return new ConcreteClassInstructionDatabaseRetrievalEntity($annotatedClass, $value);
        }

        $annotatedClass = $this->containerAdapter->fromStringToContainer($data['object_name']);
        $keyname = $this->keynameAdapter->fromDataToKeyname($data['property']);
        return new ConcreteClassInstructionDatabaseRetrievalEntity($annotatedClass, null, $keyname);


    }

}
