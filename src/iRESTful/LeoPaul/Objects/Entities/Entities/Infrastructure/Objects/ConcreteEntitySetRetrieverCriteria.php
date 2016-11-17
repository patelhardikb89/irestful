<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Exceptions\EntitySetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Orderings\Ordering;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

final class ConcreteEntitySetRetrieverCriteria implements EntitySetRetrieverCriteria {
    private $containerName;
    private $className;
    private $keyname;
    private $uuids;
    private $ordering;
    public function __construct($containerName, Keyname $keyname = null, array $uuids = null, Ordering $ordering = null) {

        if (empty($uuids)) {
            $uuids = null;
        }

        $amount = (empty($uuids) ? 0 : 1) + (empty($keyname) ? 0 : 1);
        if ($amount != 1) {
            throw new EntitySetException('There must be 1 retriever criteria.  '.$amount.' given.');
        }

        if (!is_string($containerName) || empty($containerName)) {
            throw new EntitySetException('The containerName must be a non-empty string.');
        }

        if (!empty($uuids)) {
            foreach($uuids as $oneUuid) {
                if (!($oneUuid instanceof Uuid)) {
                    throw new EntitySetException('The uuids must only contain Uuid objects.  At least one of them is not a Uuid object.');
                }
            }
        }

        $this->containerName = $containerName;
        $this->keyname = $keyname;
        $this->uuids = $uuids;
        $this->ordering = $ordering;

    }

    public function getContainerName() {
        return $this->containerName;
    }

    public function hasKeyname() {
        return !empty($this->keyname);
    }

    public function getKeyname() {
        return $this->keyname;
    }

    public function hasUuids() {
        return !empty($this->uuids);
    }

    public function getUuids() {
        return $this->uuids;
    }

    public function hasOrdering() {
        return !empty($this->ordering);
    }

    public function getOrdering() {
        return $this->ordering;
    }

}
