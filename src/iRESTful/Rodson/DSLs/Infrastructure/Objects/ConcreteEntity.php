<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Sample;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Exceptions\EntityException;

final class ConcreteEntity implements Entity {
    private $object;
    private $sample;
    public function __construct(Object $object, Sample $sample) {
        $this->object = $object;
        $this->sample = $sample;
    }

    public function getObject() {
        return $this->object;
    }

    public function getSample() {
        return $this->sample;
    }

    public function getDatabase() {
        return $this->object->getDatabase();
    }

}
