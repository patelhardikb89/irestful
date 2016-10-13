<?php
namespace iRESTful\Authenticated\Infrastructure\Types;
use iRESTful\Authenticated\Domain\Types\Keynames\Keyname;


final class ConcreteKeyname implements Keyname {
    private $keyname;
    public function __construct($keyname) {
        $this->keyname = $keyname;
    }
    
    public function get() {
        return $this->keyname;
    }
    
}
