<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\Adapters\EntityRetrieverCriteriaAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Adapters\KeynameAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\ConcreteEntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Exceptions\KeynameException;

final class ConcreteEntityRetrieverCriteriaAdapter implements EntityRetrieverCriteriaAdapter {
    private $uuidAdapter;
    private $keynameAdapter;
    public function __construct(UuidAdapter $uuidAdapter, KeynameAdapter $keynameAdapter) {
        $this->uuidAdapter = $uuidAdapter;
        $this->keynameAdapter = $keynameAdapter;
    }

    public function fromDataToRetrieverCriteria(array $data) {

        if (!isset($data['container'])) {
            throw new EntityException('The container index is mandatory in order to convert the data to an EntityRetrieverCriteria object.');
        }

        try {

            $uuid = isset($data['uuid']) ? $this->uuidAdapter->fromStringToUuid($data['uuid']) : null;
            $keyname = isset($data['keyname']) ? $this->keynameAdapter->fromDataToKeyname($data['keyname']) : null;
            $keynames = isset($data['keynames']) ? $this->keynameAdapter->fromDataToKeynames($data['keynames']) : null;

            return new ConcreteEntityRetrieverCriteria($data['container'], $uuid, $keyname, $keynames);

        } catch (UuidException $exception) {
            throw new EntityException('There was an exception while converting a binary string to a Uuid object.', $exception);
        } catch (KeynameException $exception) {
            throw new EntityException('There was an exception while converting data to a Keyname object.', $exception);
        }
    }

}
