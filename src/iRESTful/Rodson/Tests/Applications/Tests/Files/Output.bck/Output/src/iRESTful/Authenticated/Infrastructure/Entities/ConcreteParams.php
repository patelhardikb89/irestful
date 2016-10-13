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
    *   @name -> getName() -> name 
    *   @pattern -> getPattern() -> pattern 
    *   @isMandatory -> getIsMandatory() -> is_mandatory 
    */
    public function __construct(Uuid $uuid, \DateTime $createdOn, $name, ParamPattern $pattern, $isMandatory) {
        if (is_null($name) || !is_string($name)) {
            throw new \Exception("The name must be a non-null string.");
        }
        
        parent::__construct($uuid, $createdOn);
        $this->name = $name;
        $this->pattern = $pattern;
        $this->isMandatory = (bool) $isMandatory;
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
