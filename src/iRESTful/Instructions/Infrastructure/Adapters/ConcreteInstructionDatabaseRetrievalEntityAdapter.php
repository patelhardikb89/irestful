<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Adapters\EntityAdapter;
use iRESTful\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Exceptions\EntityException;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseRetrievalEntity;
use iRESTful\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;
use iRESTful\Instructions\Domain\Containers\Adapters\ContainerAdapter;

final class ConcreteInstructionDatabaseRetrievalEntityAdapter implements EntityAdapter {
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

        $annotatedClass = $this->containerAdapter->fromStringToContainer($data['object_name']);
        if ($data['property']['name'] == 'uuid') {
            $value = $this->valueAdapter->fromStringToValue($data['property']['value']);
            return new ConcreteInstructionDatabaseRetrievalEntity($annotatedClass, $value);
        }

        $keyname = $this->keynameAdapter->fromDataToKeyname($data['property']);
        return new ConcreteInstructionDatabaseRetrievalEntity($annotatedClass, null, $keyname);


    }

}
