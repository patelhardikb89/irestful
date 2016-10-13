<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Resource;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Entities\Endpoint;
use iRESTful\Authenticated\Domain\Entities\Owner;
use iRESTful\Authenticated\Domain\Entities\SharedResource;

/**
*   @container -> resource
*/
final class ConcreteResource extends AbstractEntity implements Resource {
    private $endpoint;
    private $owner;
    private $sharedResources;
    
    /**
    *   @endpoint -> getEndpoint() -> endpoint 
    *   @owner -> getOwner() -> owner 
    *   @sharedResources -> getSharedResources() -> shared_resources ** @elements-type -> iRESTful\Authenticated\Domain\Entities\SharedResource 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, Endpoint $endpoint, Owner $owner, array $sharedResources = null) {
        parent::__construct($uuid, $createdOn);
        $this->endpoint = $endpoint;
        $this->owner = $owner;
        $this->sharedResources = $sharedResources;
    }
    
    public function getEndpoint() {
        return $this->endpoint;
    }
    
    public function getOwner() {
        return $this->owner;
    }
    
    public function getSharedResources() {
        return $this->sharedResources;
    }
    
}
