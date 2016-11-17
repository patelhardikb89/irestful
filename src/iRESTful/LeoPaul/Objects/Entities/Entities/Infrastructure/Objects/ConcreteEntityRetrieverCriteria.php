<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\Criterias\EntityRetrieverCriteria;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Keynames\Keyname;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

final class ConcreteEntityRetrieverCriteria implements EntityRetrieverCriteria {
    private $containerName;
    private $uuid;
    private $keyname;
    private $keynames;
    public function __construct($containerName, Uuid $uuid = null, Keyname $keyname = null, array $keynames = null) {

        if (!is_string($containerName) || empty($containerName)) {
            throw new EntityException('The containerName ('.$containerName.') must be a non-empty string.');
        }

        $amount = (empty($uuid) ? 0 : 1) + (empty($keyname) ? 0 : 1) + (empty($keynames) ? 0 : 1);
        if ($amount != 1) {
            throw new EntityException('There must be 1 retrieval method (Uuid, Keyname or keynames).  '.$amount.' given.');
        }

        $this->containerName = $containerName;
        $this->uuid = $uuid;
        $this->keyname = $keyname;
        $this->keynames = $keynames;
    }

    public function getContainerName() {
        return $this->containerName;
    }

    public function hasUuid() {
        return !empty($this->uuid);
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function hasKeyname() {
        return !empty($this->keyname);
    }

    public function getKeyname() {
        return $this->keyname;
    }

    public function hasKeynames() {
        return !empty($this->keynames);
    }

    public function getKeynames() {
        return $this->keynames;
    }

}
