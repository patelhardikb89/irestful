<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

abstract class AbstractEntity implements Entity {
    private $uuid;
    private $createdOn;

    /**
    *   @uuid -> getUuid()->get() || getUuid()->getHumanReadable() -> uuid ++ @key ## @binary specific -> 128 ** iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter::fromStringToUuid
    *   @createdOn -> createdOn()->getTimestamp() -> created_on ## @integer max -> 64 ** iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Adapters\DateTimeAdapter::fromTimestampToDateTime
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn) {
        $this->uuid = $uuid;
        $this->createdOn = $createdOn;
    }

    protected function contains($type, array $entities = null) {

        if (empty($entities)) {
            return true;
        }

        foreach($entities as $oneEntity) {
            if ((get_class($oneEntity) != $type) && (!is_subclass_of($oneEntity, $type))) {
                return false;
            }
        }

        return true;

    }

    public function getUuid() {
        return $this->uuid;
    }

    public function createdOn() {
        return $this->createdOn;
    }

}
