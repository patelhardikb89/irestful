<?php
namespace iRESTful\Authenticated\Domain\Entities;

interface SharedResource {
                        public function getPermissions();
        
                        public function getOwners();
        
    }
