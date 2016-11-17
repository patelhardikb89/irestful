<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Criterias\Adapters\EntityRelationRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityRelationRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class ConcreteEntityRelationRetrieverCriteriaAdapter implements EntityRelationRetrieverCriteriaAdapter {
    private $uuidAdapter;
    public function __construct(UuidAdapter $uuidAdapter) {
        $this->uuidAdapter = $uuidAdapter;
    }

    public function fromDataToEntityRelationRetrieverCriteria(array $data) {

        if (!isset($data['master_container'])) {
            throw new EntityRelationException('The master_container keyname is mandatory in order to convert data to an EntityRelationRetrieverCriteria object.');
        }

        if (!isset($data['slave_container'])) {
            throw new EntityRelationException('The slave_container keyname is mandatory in order to convert data to an EntityRelationRetrieverCriteria object.');
        }

        if (!isset($data['slave_property'])) {
            throw new EntityRelationException('The slave_property keyname is mandatory in order to convert data to an EntityRelationRetrieverCriteria object.');
        }

        if (!isset($data['master_uuid'])) {
            throw new EntityRelationException('The master_uuid keyname is mandatory in order to convert data to an EntityRelationRetrieverCriteria object.');
        }

        try {

            $masterUuid = $this->uuidAdapter->fromStringToUuid($data['master_uuid']);
            return new ConcreteEntityRelationRetrieverCriteria($data['master_container'], $data['slave_container'], $data['slave_property'], $masterUuid);

        } catch (UuidException $exception) {
            throw new EntityRelationException('There was an exception while converting a string to a Uuid object.', $exception);
        }
    }

}
