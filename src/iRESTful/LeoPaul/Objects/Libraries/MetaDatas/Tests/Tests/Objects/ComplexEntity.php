<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity;

/**
*   @container -> complex_entity
*/
final class ComplexEntity extends AbstractEntity {
    private $title;
    private $subEntity;
    private $bigProperty;
    private $simpleEntities;
    private $subComplexEntity;
    private $emptyBigProperty;

    /**
    *   @title -> getTitle() -> title ++ @unique ## @string specific -> 255
    *   @subEntity -> getSubEntity() -> sub_entity
    *   @bigProperty -> getBigProperty() -> big_property
    *   @emptyBigProperty -> getEmptyBigProperty() -> empty_big_property
    *   @subComplexEntity -> getSubComplexEntity() -> sub_complex_entity
    *   @simpleEntities -> getSimpleEntities() -> simple_entities ** @elements-type -> iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, SimpleEntityInterface $subEntity, BigProperty $bigProperty, array $simpleEntities = null, ComplexEntity $subComplexEntity = null, BigProperty $emptyBigProperty = null) {

        if (empty($simpleEntities)) {
            $simpleEntities = null;
        }

        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->subEntity = $subEntity;
        $this->bigProperty = $bigProperty;
        $this->simpleEntities = $simpleEntities;
        $this->subComplexEntity = $subComplexEntity;
        $this->emptyBigProperty = $emptyBigProperty;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSubEntity() {
        return $this->subEntity;
    }

    public function getBigProperty() {
        return $this->bigProperty;
    }

    public function getSimpleEntities() {
        return $this->simpleEntities;
    }

    public function getSubComplexEntity() {
        return $this->subComplexEntity;
    }

    public function getEmptyBigProperty() {
        return $this->emptyBigProperty;
    }

}
