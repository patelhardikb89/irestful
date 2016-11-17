<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> complex_entity
*/
final class ComplexEntity extends AbstractEntity implements ComplexEntityInterface {
    private $name;
    private $slug;
    private $description;
    private $simpleEntity;
    private $simpleEntities;

    /**
    *   @slug -> getSlug() -> slug
    *   @name -> getName() -> name
    *   @description -> getDescription() -> description
    *   @simpleEntity -> getSimpleEntity() -> simple_entity
    *   @simpleEntities -> getSimpleEntities() -> simple_entities ** @elements-type -> iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects\SimpleEntityInterface
    */
    public function __construct(
        Uuid $uuid,
        \DateTime $createdOn,
        $slug,
        $name,
        $description,
        SimpleEntityInterface $simpleEntity,
        array $simpleEntities = null
    ) {

        if (empty($simpleEntities)) {
            $simpleEntities = null;
        }

        parent::__construct($uuid, $createdOn);
        $this->name = $name;
        $this->slug = $slug;
        $this->description = $description;
        $this->simpleEntity = $simpleEntity;
        $this->simpleEntities = $simpleEntities;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getSimpleEntity() {
        return $this->simpleEntity;
    }

    public function getSimpleEntities() {
        return $this->simpleEntities;
    }

}
