<?php
namespace iRESTful\Authenticated\Infrastructure\Entities;
use iRESTful\Authenticated\Domain\Entities\Params;
use iRESTful\Objects\Entities\Entities\Infrastructure\Objects\AbstractEntity;
use iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid;

                use iRESTful\Authenticated\Domain\Objects\ParamPattern;
        
/**
*   @container -> params
*/

final class ConcreteParams extends AbstractEntity implements Params {
    private $name;
        private $pattern;
        private $isMandatory;
        

    /**
    *   @name -> getName() -> name ## @string specific -> 255  
    *   @pattern -> getPattern() -> pattern ## @binary specific -> 128  
    *   @isMandatory -> getIsMandatory() -> is_mandatory ## @boolean  
    */

    public function __construct(Uuid $uuid, \DateTime $createdOn, $name, ParamPattern $pattern, $isMandatory) {
        parent::__construct($uuid, $createdOn);
        $this->name = $name;
        $this->pattern = $pattern;
        $this->isMandatory = $isMandatory;
        
    }

                public function getName() {
                return $this->name;
            }
                    public function getPattern() {
                return $this->pattern;
            }
                    public function getIsMandatory() {
                return $this->isMandatory;
            }
        
    

}
