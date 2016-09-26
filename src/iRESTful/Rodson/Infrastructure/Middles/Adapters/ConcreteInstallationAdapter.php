<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Installations\Adapters\InstallationAdapter;
use iRESTful\Rodson\Domain\Middles\Installations\Exceptions\InstallationException;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteInstallation;
use iRESTful\Rodson\Domain\Middles\Namespaces\Factories\NamespaceFactory;

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
