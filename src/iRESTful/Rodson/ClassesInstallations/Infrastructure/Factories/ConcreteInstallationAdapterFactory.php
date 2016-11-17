<?php
namespace iRESTful\Rodson\ClassesInstallations\Infrastructure\Factories;
use iRESTful\Rodson\ClassesInstallations\Domain\Adapters\Factories\InstallationAdapterFactory;
use iRESTful\Rodson\ClassesInstallations\Infrastructure\Adapters\ConcreteInstallationAdapter;
use iRESTful\Rodson\ClassesInstallations\Infrastructure\Factories\ConcreteInstallationNamespaceFactory;

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
