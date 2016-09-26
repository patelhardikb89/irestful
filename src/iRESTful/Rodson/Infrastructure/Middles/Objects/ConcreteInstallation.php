<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Installations\Installation;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Relationals\RelationalDatabase;
use iRESTful\Rodson\Domain\Middles\Configurations\Objects\ObjectConfiguration;

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

    public function getData() {
        return [
            'namespace' => $this->namespace->getData(),
            'object_configuration' => $this->objectConfiguration->getData(),
            'relational_database' => $this->database->getData()
        ];
    }

}
