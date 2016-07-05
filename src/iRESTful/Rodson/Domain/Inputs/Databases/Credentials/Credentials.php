<?php
namespace iRESTful\Rodson\Domain\Inputs\Databases\Credentials;

interface Credentials {
    public function getUsername();
    public function hasPassword();
    public function getPassword();
}
