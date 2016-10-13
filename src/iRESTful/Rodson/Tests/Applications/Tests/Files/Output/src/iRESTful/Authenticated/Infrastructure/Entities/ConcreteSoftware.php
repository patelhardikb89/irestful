<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Software;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;

                use iRESTful\Authenticated\Domain\Objects\Credentials;
                use iRESTful\Authenticated\Domain\Entities\Role;
    
/**
*   @container -> software
*/

final class ConcreteSoftware extends AbstractEntity implements Software {
    private $name;
        private $credentials;
        private $roles;
        

    /**
    *   @name -> getName() -> name ## @string specific -> 255  
    *   @credentials -> getCredentials() -> credentials ## @binary specific -> 128  
    *   @roles -> getRoles() -> roles ## @binary specific -> 128 ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Role 
    */

    public function __construct(Uuid $uuid, \DateTime $createdOn, $name, Credentials $credentials, array $roles = null) {
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
