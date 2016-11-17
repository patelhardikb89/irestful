<?php
namespace iRESTful\Rodson\ClassesTests\Infrastructure\Objects;
use iRESTful\Rodson\ClassesTests\Domain\Controllers\Controller;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\ClassesConfigurations\Domain\Configuration;

final class ConcreteTestController implements Controller {
    private $namespace;
    private $configuration;
    private $customMethodNodes;
    public function __construct(ClassNamespace $namespace, Configuration $configuration, array $customMethodNodes) {
        $this->namespace = $namespace;
        $this->configuration = $configuration;
        $this->customMethodNodes = $customMethodNodes;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getConfiguration() {
        return $this->configuration;
    }

    public function getCustomMethodNodes() {
        return $this->customMethodNodes;
    }

}
