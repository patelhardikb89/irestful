<?php
namespace iRESTful\ClassesInstallations\Infrastructure\Objects;
use iRESTful\ClassesInstallations\Domain\Installation;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\ClassesConfigurations\Domain\Objects\ObjectConfiguration;

final class ConcreteInstallation implements Installation {
    private $namespace;
    private $objectConfiguration;
    private $database;
    public function __construct(ClassNamespace $namespace, ObjectConfiguration $objectConfiguration, RelationalDatabase $database) {
        $this->namespace = $namespace;
        $this->objectConfiguration = $objectConfiguration;
        $this->database = $database;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getObjectConfiguration() {
        return $this->objectConfiguration;
    }

    public function getRelationalDatabase() {
        return $this->database;
    }

}
