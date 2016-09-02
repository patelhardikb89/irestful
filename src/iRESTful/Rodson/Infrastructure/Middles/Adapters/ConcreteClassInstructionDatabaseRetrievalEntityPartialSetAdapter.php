<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Adapters\EntityPartialSetAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Retrievals\EntityPartialSets\Exceptions\EntityPartialSetException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseRetrievalEntityPartialSet;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\ContainerAdapter;

final class ConcreteClassInstructionDatabaseRetrievalEntityPartialSetAdapter implements EntityPartialSetAdapter {
    private $valueAdapter;
    private $containerAdapter;
    public function __construct(ValueAdapter $valueAdapter, ContainerAdapter $containerAdapter) {
        $this->valueAdapter = $valueAdapter;
        $this->containerAdapter = $containerAdapter;
    }

    public function fromDataToEntityPartialSet(array $data) {

        if (!isset($data['object_name'])) {
            throw new EntityPartialSetException('The object_name keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        if (!isset($data['index'])) {
            throw new EntityPartialSetException('The index keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        if (!isset($data['amount'])) {
            throw new EntityPartialSetException('The amount keyname is mandatory in order to convert data to an EntityPartialSet object.');
        }

        $container = $this->containerAdapter->fromStringToContainer($data['object_name']);
        $index = $this->valueAdapter->fromStringToValue($data['index']);
        $amount = $this->valueAdapter->fromStringToValue($data['amount']);
        return new ConcreteClassInstructionDatabaseRetrievalEntityPartialSet($container, $index, $amount);
    }

}
