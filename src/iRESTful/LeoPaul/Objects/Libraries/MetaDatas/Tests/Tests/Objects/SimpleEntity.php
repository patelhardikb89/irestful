<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\AbstractEntity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

/**
*   @container -> simple_entity
*/
final class SimpleEntity extends AbstractEntity implements SimpleEntityInterface {
    private $title;
    private $slug;
    private $domainNames;
    private $float;

    /**
    *   @title -> getTitle() -> title ++ @default -> 'my-title' ## @string specific -> 255
    *   @slug -> getSlug() -> slug ++ @unique @default -> 'my-slug' ## @string specific -> 255
    *   @domainNames -> getDomainNames() -> domain_names ## @string specific -> 255 ** iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface::fromDomainNamesToString || iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Adapters\DomainNameAdapterInterface::fromStringToDomainNames
    *   @float -> getFloat() -> float ++ @default -> 'null' ## @float digits -> 20 precision -> 3
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $slug, array $domainNames = null, $float = null) {

        if (empty($domainNames)) {
            $domainNames = null;
        }

        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->slug = $slug;
        $this->domainNames = $domainNames;
        $this->float = $float;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getFloat() {
        return $this->float;
    }

    public function getDomainNames() {
        return $this->domainNames;
    }

    public function notAGetter() {
        return 'not a getter';
    }

}
