<?php
namespace iRESTful\Rodson\Domain\Databases\Credentials;

interface Credentials {
    public function getUsername();
    public function hasPassword();
    public function getPassword();
}
