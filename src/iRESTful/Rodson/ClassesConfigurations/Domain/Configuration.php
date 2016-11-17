<?php
namespace iRESTful\Rodson\ClassesConfigurations\Domain;

interface Configuration {
    public function getNamespace();
    public function getObjectConfiguration();
    public function getDatabases();
    public function hasControllerNode();
    public function getControllerNode();
}
