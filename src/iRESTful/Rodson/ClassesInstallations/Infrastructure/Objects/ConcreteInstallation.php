<?php
namespace iRESTful\Rodson\ClassesInstallations\Infrastructure\Objects;
use iRESTful\Rodson\ClassesInstallations\Domain\Installation;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\ClassesConfigurations\Domain\Objects\ObjectConfiguration;

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
