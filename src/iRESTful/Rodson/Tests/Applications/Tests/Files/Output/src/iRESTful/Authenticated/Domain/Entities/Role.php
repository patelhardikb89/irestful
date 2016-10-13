<?php
namespace iRESTful\Authenticated\Domain\Entities;

interface Role {
                        public function getTitle();
        
                        public function getDescription();
        
                        public function getPermissions();
        
    }
