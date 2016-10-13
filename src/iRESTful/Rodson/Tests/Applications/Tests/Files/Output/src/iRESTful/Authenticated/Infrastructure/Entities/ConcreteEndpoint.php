<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Endpoint;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;

            use iRESTful\Authenticated\Domain\Objects\Pattern;
                    use iRESTful\Authenticated\Domain\Entities\Params;
    
/**
*   @container -> endpoint
*/

final class ConcreteEndpoint extends AbstractEntity implements Endpoint {
    private $pattern;
        private $isUserMandatory;
        private $params;
        

    /**
    *   @pattern -> getPattern() -> pattern ## @binary specific -> 128  
    *   @isUserMandatory -> getIsUserMandatory() -> is_user_mandatory ## @boolean  
    *   @params -> getParams() -> params ## @binary specific -> 128 ** @elements-type -> iRESTful\Authenticated\Domain\Entities\Params 
    */

    public function __construct(Uuid $uuid, \DateTime $createdOn, Pattern $pattern, $isUserMandatory, array $params = null) {
        parent::__construct($uuid, $createdOn);
        $this->pattern = $pattern;
        $this->isUserMandatory = $isUserMandatory;
        $this->params = $params;
        
    }

                public function getPattern() {
                return $this->pattern;
            }
                    public function getIsUserMandatory() {
                return $this->isUserMandatory;
            }
                    public function getParams() {
                return $this->params;
            }
        
                public function has_method(array $first, $second) {
        $pattern = $this->pattern;
        if ($test = 44) {
            return null;
        }
        $another = $line;
        }

        

}
