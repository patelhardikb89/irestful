<?php
namespace iRESTful\Authenticated\Infrastructure\Objects;
use iRESTful\Authenticated\Domain\Objects\Pattern;

                use iRESTful\Authenticated\Domain\Types\Uris\Uri;
    
final class ConcretePattern implements Pattern {
    private $regexPattern;
        private $specificUri;
        

    /**
    *   @regexPattern -> getRegexPattern() -> regex_pattern ## @string specific -> 255  
    *   @specificUri -> getSpecificUri()->get() -> specific_uri ## @string max -> 255 ** iRESTful\Authenticated\Domain\Types\Uris\Adapters\UriAdapter::fromStringToUri  
    */

    public function __construct($regexPattern, Uri $specificUri) {
        $this->regexPattern = $regexPattern;
        $this->specificUri = $specificUri;
        
    }

                public function getRegexPattern() {
                return $this->regexPattern;
            }
                    public function getSpecificUri() {
                return $this->specificUri;
            }
        
    

}
