<?php
namespace iRESTful\Rodson\ClassesApplications\Infrastructure\Objects;
use iRESTful\Rodson\ClassesApplications\Domain\Application;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\ClassesConfigurations\Domain\Configuration;

final class ConcreteApplication implements Application {
    private $namespace;
    private $configuration;
    public function __construct(ClassNamespace $namespace, Configuration $configuration) {
        $this->namespace = $namespace;
        $this->configuration = $configuration;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getConfiguration() {
        return $this->configuration;
    }

}
