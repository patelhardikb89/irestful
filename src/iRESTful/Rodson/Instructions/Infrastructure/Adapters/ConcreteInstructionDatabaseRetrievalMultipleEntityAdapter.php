<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples\Adapters\MultipleEntityAdapter;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples\Exceptions\MultipleEntityException;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseRetrievalMultipleEntity;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\ContainerAdapter;

final class ConcreteInstructionDatabaseRetrievalMultipleEntityAdapter implements MultipleEntityAdapter {
    private $keynameAdapter;
    private $valueAdapter;
    private $containerAdapter;
    public function __construct(KeynameAdapter $keynameAdapter, ValueAdapter $valueAdapter, ContainerAdapter $containerAdapter) {
        $this->keynameAdapter = $keynameAdapter;
        $this->valueAdapter = $valueAdapter;
        $this->containerAdapter = $containerAdapter;
    }

    public function fromDataToMultipleEntity(array $data) {

        if (!isset($data['object_name'])) {
            throw new MultipleEntityException('The object_name keyname is mandatory in order to convert data to a MultipleEntity object.');
        }

        if (!isset($data['property']) || !isset($data['property']['name'])) {
            throw new MultipleEntityException('The property->name keyname is mandatory in order to convert data to a MultipleEntity object.');
        }

        if (!isset($data['property']['value'])) {
            throw new MultipleEntityException('The property->value keyname is mandatory in order to convert data to a MultipleEntity object.');
        }

        $container = $this->containerAdapter->fromStringToContainer($data['object_name']);
        if ($data['property']['name'] == 'uuid') {
            $value = $this->valueAdapter->fromStringToValue($data['property']['value']);
            return new ConcreteInstructionDatabaseRetrievalMultipleEntity($container, $value);
        }

        $keyname = $this->keynameAdapter->fromDataToKeyname($data['property']);
        return new ConcreteInstructionDatabaseRetrievalMultipleEntity($container, null, $keyname);
    }

}
