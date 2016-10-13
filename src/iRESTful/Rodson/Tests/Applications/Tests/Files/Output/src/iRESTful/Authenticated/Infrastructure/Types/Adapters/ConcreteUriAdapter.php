<?php
namespace iRESTful\Authenticated\Infrastructure\Types\Adapters;
use iRESTful\Authenticated\Domain\Types\Uris\Adapters\UriAdapter;

final class ConcreteUriAdapter implements UriAdapter {
    

    public function __construct() {
        
    }

            public function fromStringToUri($value) {
            return new \iRESTful\Authenticated\Infrastructure\Types\ConcreteUri($value);
        }
    
}
