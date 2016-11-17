<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> simple_entity
*/
final class SimpleEntity extends AbstractEntity implements SimpleEntityInterface {
    private $title;
    private $description;
    private $slug;

    /**
    *   @title -> getTitle() -> title
    *   @description -> getDescription() -> description
    *   @slug -> getSlug() -> slug
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $description, $slug) {
        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->description = $description;
        $this->slug = $slug;
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

    public function notAGetter() {
        return 'not a getter';
    }

}
