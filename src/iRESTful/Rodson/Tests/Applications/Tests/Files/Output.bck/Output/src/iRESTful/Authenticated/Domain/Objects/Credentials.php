<?php
namespace iRESTful\Authenticated\Domain\Objects;


interface Credentials {
    public function getUsername();
    public function getHashed_password();
    public function getPassword();
}

