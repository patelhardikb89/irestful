<?php
namespace iRESTful\Rodson\ClassesApplications\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesApplications\Domain\Adapters\ApplicationAdapter;
use iRESTful\Rodson\ClassesConfigurations\Domain\Configuration;
use iRESTful\Rodson\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\ClassesApplications\Infrastructure\Objects\ConcreteApplication;

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
