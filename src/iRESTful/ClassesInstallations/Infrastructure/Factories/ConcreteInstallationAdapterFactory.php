<?php
namespace iRESTful\ClassesInstallations\Infrastructure\Factories;
use iRESTful\ClassesInstallations\Domain\Adapters\Factories\InstallationAdapterFactory;
use iRESTful\ClassesInstallations\Infrastructure\Adapters\ConcreteInstallationAdapter;
use iRESTful\ClassesInstallations\Infrastructure\Factories\ConcreteInstallationNamespaceFactory;

final class ConcreteInstallationAdapterFactory implements InstallationAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $namespaceFactory = new ConcreteInstallationNamespaceFactory($this->baseNamespace);
        return new ConcreteInstallationAdapter($namespaceFactory);
    }

}
