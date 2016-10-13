<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Api;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Types\BaseUrls\BaseUrl;
use iRESTful\Authenticated\Domain\Entities\Endpoint;

/**
*   @container -> api
*/
final class ConcreteApi extends AbstractEntity implements Api {
    private $baseUrl;
    private $endpoints;

    /**
    *   @baseUrl -> getBaseUrl()->get() -> base_url ** iRESTful\Authenticated\Domain\Types\BaseUrls\Adapters\BaseUrlAdapter::fromStringToBase_url
    *   @endpoints -> getEndpoints() -> endpoints ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Endpoint
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, BaseUrl $baseUrl, array $endpoints = null) {
        parent::__construct($uuid, $createdOn);
        $this->baseUrl = $baseUrl;
        $this->endpoints = $endpoints;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getEndpoints() {
        return $this->endpoints;
    }

}
