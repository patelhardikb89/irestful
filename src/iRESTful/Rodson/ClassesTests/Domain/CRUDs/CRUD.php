<?php
namespace iRESTful\Rodson\ClassesTests\Domain\CRUDs;
use iRESTful\Rodson\ClassesInstallations\Domain\Installation;

interface CRUD {
    public function getNamespace();
    public function getSamples();
    public function getInstallation();
}
