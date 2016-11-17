<?php
namespace iRESTful\ClassesTests\Domain\CRUDs;
use iRESTful\ClassesInstallations\Domain\Installation;

interface CRUD {
    public function getNamespace();
    public function getSamples();
    public function getInstallation();
}
