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
    *   @keyname -> getKeyname()->get() -> keyname ## @string max -> 255 ** iRESTful\Authenticated\Domain\Types\Keynames\Adapters\KeynameAdapter::fromStringToKeyname  
    *   @title -> getTitle() -> title ## @string specific -> 255  
    *   @description -> getDescription() -> description ## @string specific -> 255  
    *   @roles -> getRoles() -> roles ## @binary specific -> 128 ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Role 
    */

    public function __construct(Uuid $uuid, \DateTime $createdOn, Keyname $keyname, $title, $description, array $roles = null) {
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
