<?php
namespace iRESTful\DSLs\Domain\Projects\Databases\Credentials;

interface Credentials {
    public function getUsername();
    public function hasPassword();
    public function getPassword();
}
