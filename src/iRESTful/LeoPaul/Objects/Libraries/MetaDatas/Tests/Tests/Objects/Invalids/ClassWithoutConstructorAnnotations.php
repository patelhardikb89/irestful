<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\Invalids;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> simple_entity
*/
final class ClassWithoutConstructorAnnotations extends AbstractEntity {
    private $title;
    private $slug;
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $slug) {
        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->slug = $slug;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function notAGetter() {
        return 'not a getter';
    }

}
