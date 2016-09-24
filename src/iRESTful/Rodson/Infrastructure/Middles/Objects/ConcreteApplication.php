<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Applications\Application;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;

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

    public function getData() {
        return [
            'namespace' => $this->namespace->getData(),
            'configuration' => $this->configuration->getData()
        ];
    }

}
