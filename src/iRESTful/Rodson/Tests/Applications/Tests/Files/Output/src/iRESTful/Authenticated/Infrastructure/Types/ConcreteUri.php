<?php
namespace iRESTful\Authenticated\Infrastructure\Types;
use iRESTful\Authenticated\Domain\Types\Uris\Uri;

final class ConcreteUri implements Uri {
    private $uri;
        
    public function __construct($uri) {
        $this->uri = $uri;
        
    }

                public function get() {
                return $this->uri;
            }
        

}
