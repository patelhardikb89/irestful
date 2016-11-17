<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

abstract class AbstractEntity {
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

    protected function contains(array $entities, $type) {

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
