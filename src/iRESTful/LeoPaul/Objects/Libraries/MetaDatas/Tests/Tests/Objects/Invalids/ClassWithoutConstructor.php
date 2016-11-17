<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\Invalids;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> simple_entity
*/
final class ClassWithoutConstructor {
    private $title;
    private $slug;

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
