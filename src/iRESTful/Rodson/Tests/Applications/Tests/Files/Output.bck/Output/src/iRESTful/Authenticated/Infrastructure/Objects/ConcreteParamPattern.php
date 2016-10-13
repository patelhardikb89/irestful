<?php
namespace iRESTful\Authenticated\Infrastructure\Objects;
use iRESTful\Authenticated\Domain\Objects\ParamPattern;
use iRESTful\Authenticated\Domain\Types\StringNumerics\StringNumeric;


final class ConcreteParamPattern implements ParamPattern {
    private $regexPattern;
    private $specificValue;
    
    /**
    *   @regexPattern -> getRegexPattern() -> regex_pattern 
    *   @specificValue -> getSpecificValue()->get() -> specific_value ** iRESTful\Authenticated\Domain\Types\StringNumerics\Adapters\StringNumericAdapter::fromStringToString_numeric 
    */
    public function __construct($regexPattern = null, StringNumeric $specificValue = null) {
        if (!is_null($regexPattern) && !is_string($regexPattern)) {
            throw new \Exception("The regexPattern must be a string if non-null.");
        }
        $this->regexPattern = $regexPattern;
        $this->specificValue = $specificValue;
    }
    
    public function getRegexPattern() {
        return $this->regexPattern;
    }
    
    public function getSpecificValue() {
        return $this->specificValue;
    }
    
}
