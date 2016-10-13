<?php
namespace iRESTful\ClassesApplications\Infrastructure\Adapters;
use iRESTful\ClassesApplications\Domain\Adapters\ApplicationAdapter;
use iRESTful\ClassesConfigurations\Domain\Configuration;
use iRESTful\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\ClassesApplications\Infrastructure\Objects\ConcreteApplication;

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
