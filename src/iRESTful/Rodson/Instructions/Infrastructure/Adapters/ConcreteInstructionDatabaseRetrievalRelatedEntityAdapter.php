<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\Adapters\RelatedEntityAdapter;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Relations\Exceptions\RelatedEntityException;
use iRESTful\Rodson\Instructions\Domain\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Instructions\Domain\Containers\Adapters\ContainerAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseRetrievalRelatedEntity;

final class ConcreteInstructionDatabaseRetrievalRelatedEntityAdapter implements RelatedEntityAdapter {
    private $valueAdapter;
    private $containerAdapter;
    public function __construct(ValueAdapter $valueAdapter, ContainerAdapter $containerAdapter) {
        $this->valueAdapter = $valueAdapter;
        $this->containerAdapter = $containerAdapter;
    }

    public function fromDataToRelatedEntity(array $data) {

        if (!isset($data['master']['container'])) {
            throw new RelatedEntityException('The master->container keyname is mandatory in order to convert data to a RelatedEntity object.');
        }

        if (!isset($data['master']['uuid'])) {
            throw new RelatedEntityException('The master->uuid keyname is mandatory in order to convert data to a RelatedEntity object.');
        }

        if (!isset($data['slave']['property'])) {
            throw new RelatedEntityException('The slave->property keyname is mandatory in order to convert data to a RelatedEntity object.');
        }

        if (!isset($data['slave']['container'])) {
            throw new RelatedEntityException('The slave->container keyname is mandatory in order to convert data to a RelatedEntity object.');
        }

        $masterContainer = $this->containerAdapter->fromStringToContainer($data['master']['container']);
        $masterUuidValue = $this->valueAdapter->fromStringToValue($data['master']['uuid']);
        $slaveProperty = $this->valueAdapter->fromStringToValue($data['slave']['property']);
        $slaveContainer = $this->containerAdapter->fromStringToContainer($data['slave']['container']);

        return new ConcreteInstructionDatabaseRetrievalRelatedEntity($masterContainer, $masterUuidValue, $slaveProperty, $slaveContainer);

    }

}
