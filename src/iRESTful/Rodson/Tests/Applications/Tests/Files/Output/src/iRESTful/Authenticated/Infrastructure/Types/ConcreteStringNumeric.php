<?php
namespace iRESTful\Authenticated\Infrastructure\Types;
use iRESTful\Authenticated\Domain\Types\StringNumerics\StringNumeric;

final class ConcreteStringNumeric implements StringNumeric {
    private $stringNumeric;
        
    public function __construct($stringNumeric) {
        $this->stringNumeric = $stringNumeric;
        
    }

                public function get() {
                return $this->stringNumeric;
            }
        

}
