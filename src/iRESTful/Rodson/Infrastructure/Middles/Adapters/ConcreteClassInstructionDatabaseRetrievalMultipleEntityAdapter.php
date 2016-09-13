<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Adapters\MultipleEntityAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Multiples\Exceptions\MultipleEntityException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalMultipleEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\Keynames\Adapters\KeynameAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\ContainerAdapter;

final class ConcreteClassInstructionDatabaseRetrievalMultipleEntityAdapter implements MultipleEntityAdapter {
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
            $value = $this->valueAdapter->fromStringToValue($data['property']['name']);
            return new ConcreteClassInstructionDatabaseRetrievalMultipleEntity($container, $value);
        }

        $keyname = $this->keynameAdapter->fromDataToKeyname($data['property']);
        return new ConcreteClassInstructionDatabaseRetrievalMultipleEntity($container, null, $keyname);
    }

}
