<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Owner;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Entities\Software;
use iRESTful\Authenticated\Domain\Entities\User;

/**
*   @container -> owner
*/
final class ConcreteOwner extends AbstractEntity implements Owner {
    private $software;
    private $user;
    
    /**
    *   @software -> getSoftware() -> software 
    *   @user -> getUser() -> user 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, Software $software, User $user = null) {
        parent::__construct($uuid, $createdOn);
        $this->software = $software;
        $this->user = $user;
    }
    
    public function getSoftware() {
        return $this->software;
    }
    
    public function getUser() {
        return $this->user;
    }
    
}
