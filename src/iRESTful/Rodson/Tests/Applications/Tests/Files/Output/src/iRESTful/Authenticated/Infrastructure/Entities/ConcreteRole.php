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
    *   @title -> getTitle() -> title ## @string specific -> 255  
    *   @description -> getDescription() -> description ## @string specific -> 255  
    *   @permissions -> getPermissions() -> permissions ## @binary specific -> 128 ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Permission 
    */

    public function __construct(Uuid $uuid, \DateTime $createdOn, $title, $description, array $permissions = null) {
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
