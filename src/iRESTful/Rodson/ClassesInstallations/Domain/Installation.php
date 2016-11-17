<?php
namespace iRESTful\Rodson\ClassesInstallations\Domain;

interface Installation {
    public function getNamespace();
    public function getObjectConfiguration();
    public function getRelationalDatabase();
}
