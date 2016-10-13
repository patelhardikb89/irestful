<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Factories;
use iRESTful\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteConfigurationNamespaceFactory implements NamespaceFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $name = $this->baseNamespace[count($this->baseNamespace) - 1].'Configuration';
        $merged = array_merge($this->baseNamespace, ['Infrastructure', 'Configurations', $name]);
        return new ConcreteNamespace($merged);
    }

}
