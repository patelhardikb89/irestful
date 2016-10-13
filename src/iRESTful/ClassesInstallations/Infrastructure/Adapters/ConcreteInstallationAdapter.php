<?php
namespace iRESTful\ClassesInstallations\Infrastructure\Adapters;
use iRESTful\ClassesInstallations\Domain\Adapters\InstallationAdapter;
use iRESTful\ClassesInstallations\Domain\Exceptions\InstallationException;
use iRESTful\ClassesInstallations\Infrastructure\Objects\ConcreteInstallation;
use iRESTful\Classes\Domain\Namespaces\Factories\NamespaceFactory;

final class ConcreteInstallationAdapter implements InstallationAdapter {
    private $namespaceFactory;
    public function __construct(NamespaceFactory $namespaceFactory) {
        $this->namespaceFactory = $namespaceFactory;
    }

    public function fromDataToInstallation(array $data) {

        if (!isset($data['object_configuration'])) {
            throw new InstallationException('The object_configuration keyname is mandatory in order to convert data to an Installation object.');
        }

        if (!isset($data['relational_database'])) {
            throw new InstallationException('The relational_database keyname is mandatory in order to convert data to an Installation object.');
        }

        $namespace = $this->namespaceFactory->create();
        return new ConcreteInstallation($namespace, $data['object_configuration'], $data['relational_database']);

    }

}
