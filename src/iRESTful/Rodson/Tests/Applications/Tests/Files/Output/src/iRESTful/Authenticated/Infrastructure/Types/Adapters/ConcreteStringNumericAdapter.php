<?php
namespace iRESTful\Authenticated\Infrastructure\Types\Adapters;
use iRESTful\Authenticated\Domain\Types\StringNumerics\Adapters\StringNumericAdapter;

final class ConcreteStringNumericAdapter implements StringNumericAdapter {
    

    public function __construct() {
        
    }

            public function fromStringToStringNumeric($value) {
            return new \iRESTful\Authenticated\Infrastructure\Types\ConcreteStringNumeric($value);
        }
    
}
