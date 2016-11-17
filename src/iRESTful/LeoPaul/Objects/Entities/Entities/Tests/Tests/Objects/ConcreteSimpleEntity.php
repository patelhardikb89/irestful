<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;

/**
*   @container -> simple_entity
*/
final class ConcreteSimpleEntity extends AbstractEntity implements SimpleEntity {
    private $title;
    private $description;
    private $slug;
    private $subEntities;

    /**
    *   @title -> getTitle() -> title
    *   @description -> getDescription() -> description
    *   @slug -> getSlug() -> slug
    *   @subEntities -> getSubEntities() -> sub_entities ** @elements-type -> iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\ConcreteSimpleEntity
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $description, $slug, array $subEntities = null) {

        if (!$this->contains('iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Tests\Objects\SimpleEntity', $subEntities)) {
            throw new EntityException('The subEntities must be SimpleEntity objects, if not empty.');
        }

        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->description = $description;
        $this->slug = $slug;
        $this->subEntities = $subEntities;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function hasSubEntities() {
        return !empty($this->subEntities);
    }

    public function getSubEntities() {
        return $this->subEntities;
    }

    public function notAGetter() {
        return 'not a getter';
    }

}
