<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Applications\Adapters\ApplicationAdapter;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteApplication;

final class ConcreteApplicationAdapter implements ApplicationAdapter {
    private $namespaceFactory;
    public function __construct(NamespaceFactory $namespaceFactory) {
        $this->namespaceFactory = $namespaceFactory;
    }

    public function fromConfigurationToApplication(Configuration $configuration) {
        $namespace = $this->namespaceFactory->create();
        return new ConcreteApplication($namespace, $configuration);
    }

}
