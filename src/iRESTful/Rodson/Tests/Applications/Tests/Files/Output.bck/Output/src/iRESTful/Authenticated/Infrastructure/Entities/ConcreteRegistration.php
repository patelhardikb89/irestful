<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Registration;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Types\Keynames\Keyname;
use iRESTful\Authenticated\Domain\Entities\Role;

/**
*   @container -> registration
*/
final class ConcreteRegistration extends AbstractEntity implements Registration {
    private $keyname;
    private $title;
    private $description;
    private $roles;
    
    /**
    *   @keyname -> getKeyname()->get() -> keyname ** iRESTful\Authenticated\Domain\Types\Keynames\Adapters\KeynameAdapter::fromStringToKeyname 
    *   @title -> getTitle() -> title 
    *   @description -> getDescription() -> description 
    *   @roles -> getRoles() -> roles ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Role 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, Keyname $keyname, $title, $description = null, array $roles = null) {
        if (is_null($title) || !is_string($title)) {
            throw new \Exception("The title must be a non-null string.");
        }
        
        if (!is_null($description) && !is_string($description)) {
            throw new \Exception("The description must be a string if non-null.");
        }
        parent::__construct($uuid, $createdOn);
        $this->keyname = $keyname;
        $this->title = $title;
        $this->description = $description;
        $this->roles = $roles;
    }
    
    public function getKeyname() {
        return $this->keyname;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getRoles() {
        return $this->roles;
    }
    
}
