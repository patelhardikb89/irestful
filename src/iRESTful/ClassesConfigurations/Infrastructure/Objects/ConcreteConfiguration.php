<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Objects;
use iRESTful\ClassesConfigurations\Domain\Configuration;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\ClassesConfigurations\Domain\Objects\ObjectConfiguration;
use iRESTful\DSLs\Domain\Projects\Databases\Database;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\ControllerNode;
use iRESTful\ClassesConfigurations\Domain\Exceptions\ConfigurationException;

final class ConcreteConfiguration implements Configuration {
    private $namespace;
    private $objectConfiguration;
    private $databases;
    private $controllerNode;
    public function __construct(ClassNamespace $namespace, ObjectConfiguration $objectConfiguration, array $databases, ControllerNode $controllerNode = null) {

        if (empty($databases)) {
            throw new ConfigurationException('The databases must be non-empty.');
        }

        foreach($databases as $oneDatabase) {
            if (!($oneDatabase instanceof Database)) {
                throw new ConfigurationException('The databases array must only contain Database objects.');
            }
        }

        $this->namespace = $namespace;
        $this->objectConfiguration = $objectConfiguration;
        $this->databases = $databases;
        $this->controllerNode = $controllerNode;

    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getObjectConfiguration() {
        return $this->objectConfiguration;
    }

    public function getDatabases() {
        return $this->databases;
    }

    public function hasControllerNode() {
        return !empty($this->controllerNode);
    }

    public function getControllerNode() {
        return $this->controllerNode;
    }

}
