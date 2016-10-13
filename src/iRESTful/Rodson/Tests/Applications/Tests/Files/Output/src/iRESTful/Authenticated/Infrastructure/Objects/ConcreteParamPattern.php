<?php
namespace iRESTful\Authenticated\Infrastructure\Objects;
use iRESTful\Authenticated\Domain\Objects\ParamPattern;

                use iRESTful\Authenticated\Domain\Types\StringNumerics\StringNumeric;
    
final class ConcreteParamPattern implements ParamPattern {
    private $regexPattern;
        private $specificValue;
        

    /**
    *   @regexPattern -> getRegexPattern() -> regex_pattern ## @string specific -> 255  
    *   @specificValue -> getSpecificValue()->get() -> specific_value ## @string max -> 255 ** iRESTful\Authenticated\Domain\Types\StringNumerics\Adapters\StringNumericAdapter::fromStringToStringNumeric  
    */

    public function __construct($regexPattern, StringNumeric $specificValue) {
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
