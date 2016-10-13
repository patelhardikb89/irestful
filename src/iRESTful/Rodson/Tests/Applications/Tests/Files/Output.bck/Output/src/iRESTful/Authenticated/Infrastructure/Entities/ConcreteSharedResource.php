<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\SharedResource;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Entities\Permission;
use iRESTful\Authenticated\Domain\Entities\Owner;

/**
*   @container -> shared_resource
*/
final class ConcreteSharedResource extends AbstractEntity implements SharedResource {
    private $permissions;
    private $owners;
    
    /**
    *   @permissions -> getPermissions() -> permissions ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Permission 
    *   @owners -> getOwners() -> owners ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Owner 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, array $permissions = null, array $owners = null) {
        parent::__construct($uuid, $createdOn);
        $this->permissions = $permissions;
        $this->owners = $owners;
    }
    
    public function getPermissions() {
        return $this->permissions;
    }
    
    public function getOwners() {
        return $this->owners;
    }
    
}
