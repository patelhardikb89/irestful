<?php
namespace iRESTful\Authenticated\Infrastructure\Objects;
use iRESTful\Authenticated\Domain\Objects\Pattern;
use iRESTful\Authenticated\Domain\Types\Uris\Uri;


final class ConcretePattern implements Pattern {
    private $regexPattern;
    private $specificUri;
    
    /**
    *   @regexPattern -> getRegexPattern() -> regex_pattern 
    *   @specificUri -> getSpecificUri()->get() -> specific_uri ** iRESTful\Authenticated\Domain\Types\Uris\Adapters\UriAdapter::fromStringToUri 
    */
    public function __construct($regexPattern = null, Uri $specificUri = null) {
        if (!is_null($regexPattern) && !is_string($regexPattern)) {
            throw new \Exception("The regexPattern must be a string if non-null.");
        }
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
