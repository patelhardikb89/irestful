<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Samples\Sample;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Exceptions\EntityException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Data\EntityData;

final class ConcreteEntity implements Entity {
    private $object;
    private $sample;
    private $entityDatas;
    public function __construct(Object $object, Sample $sample, array $entityDatas = null) {

        if (empty($entityDatas)) {
            $entityDatas = null;
        }

        if (!empty($entityDatas)) {
            foreach($entityDatas as $oneEntityData) {
                if (!($oneEntityData instanceof EntityData)) {
                    throw new EntityException('The entityDatas array must only contain EntityData objects.');
                }
            }
        }

        $this->object = $object;
        $this->sample = $sample;
        $this->entityDatas = $entityDatas;
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

    public function hasEntityDatas() {
        return !empty($this->entityDatas);
    }

    public function getEntityDatas() {
        return $this->entityDatas;
    }

}
