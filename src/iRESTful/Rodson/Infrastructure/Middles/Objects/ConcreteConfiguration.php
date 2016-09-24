<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Configurations\Objects\ObjectConfiguration;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Nodes\ControllerNode;
use iRESTful\Rodson\Domain\Middles\Configurations\Exceptions\ConfigurationException;

final class ConcreteConfiguration implements Configuration {
    private $namespace;
    private $objectConfiguration;
    private $databases;
    private $controllerNode;
    public function __construct(ClassNamespace $namespace, ObjectConfiguration $objectConfiguration, ControllerNode $controllerNode, array $databases) {

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

    public function getControllerNode() {
        return $this->controllerNode;
    }

    public function getData() {

        $databases = $this->databases;
        array_walk($databases, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'namespace' => $this->namespace->getData(),
            'object_configuration' => $this->objectConfiguration->getData(),
            'databases' => $databases,
            'controller_node' => $this->controllerNode->getData()
        ];
    }

}
