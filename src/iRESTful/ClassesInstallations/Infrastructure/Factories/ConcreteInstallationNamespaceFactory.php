<?php
namespace iRESTful\ClassesInstallations\Infrastructure\Factories;
use iRESTful\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteInstallationNamespaceFactory implements NamespaceFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $name = $this->baseNamespace[count($this->baseNamespace) - 1].'Installation';
        $merged = array_merge($this->baseNamespace, ['Installations', $name]);
        return new ConcreteNamespace($merged);
    }

}
