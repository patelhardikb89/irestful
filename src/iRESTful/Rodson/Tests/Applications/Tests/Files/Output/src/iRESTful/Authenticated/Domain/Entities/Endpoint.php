<?php
namespace iRESTful\Authenticated\Domain\Entities;

interface Endpoint {
                        public function getPattern();
        
                        public function getIsUserMandatory();
        
                        public function getParams();
        
                        public function has_method(array $first, $second);
        
    }
