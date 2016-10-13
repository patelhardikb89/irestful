<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Role;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\Authenticated\Domain\Entities\Permission;

/**
*   @container -> role
*/
final class ConcreteRole extends AbstractEntity implements Role {
    private $title;
    private $description;
    private $permissions;
    
    /**
    *   @title -> getTitle() -> title 
    *   @description -> getDescription() -> description 
    *   @permissions -> getPermissions() -> permissions ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Permission 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $description = null, array $permissions = null) {
        if (is_null($title) || !is_string($title)) {
            throw new \Exception("The title must be a non-null string.");
        }
        
        if (!is_null($description) && !is_string($description)) {
            throw new \Exception("The description must be a string if non-null.");
        }
        parent::__construct($uuid, $createdOn);
        $this->title = $title;
        $this->description = $description;
        $this->permissions = $permissions;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getPermissions() {
        return $this->permissions;
    }
    
}
