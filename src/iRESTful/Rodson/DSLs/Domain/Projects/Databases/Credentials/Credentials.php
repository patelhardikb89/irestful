<?php
namespace iRESTful\Rodson\DSLs\Domain\Projects\Databases\Credentials;

interface Credentials {
    public function getUsername();
    public function hasPassword();
    public function getPassword();
}
