<?php
namespace iRESTful\Authenticated\Infrastructure\Types\Adapters;
use iRESTful\Authenticated\Domain\Types\BaseUrls\Adapters\BaseUrlAdapter;

final class ConcreteBaseUrlAdapter implements BaseUrlAdapter {
    

    public function __construct() {
        
    }

            public function fromStringToBaseUrl($value) {
            return new \iRESTful\Authenticated\Infrastructure\Types\ConcreteBaseUrl($value);
        }
    
}
