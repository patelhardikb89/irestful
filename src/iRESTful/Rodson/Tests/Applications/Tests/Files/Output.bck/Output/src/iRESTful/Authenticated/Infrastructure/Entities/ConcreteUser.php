<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\User;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Objects\Credentials;
use iRESTful\Authenticated\Domain\Entities\Role;

/**
*   @container -> user
*/
final class ConcreteUser extends AbstractEntity implements User {
    private $name;
    private $credentials;
    private $roles;
    
    /**
    *   @name -> getName() -> name 
    *   @credentials -> getCredentials() -> credentials 
    *   @roles -> getRoles() -> roles ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Role 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $name, Credentials $credentials, array $roles = null) {
        if (is_null($name) || !is_string($name)) {
            throw new \Exception("The name must be a non-null string.");
        }
        
        parent::__construct($uuid, $createdOn);
        $this->name = $name;
        $this->credentials = $credentials;
        $this->roles = $roles;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getCredentials() {
        return $this->credentials;
    }
    
    public function getRoles() {
        return $this->roles;
    }
    
}
