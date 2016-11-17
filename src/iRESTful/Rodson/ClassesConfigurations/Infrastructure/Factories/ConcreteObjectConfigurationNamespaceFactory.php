<?php
namespace iRESTful\Rodson\ClassesConfigurations\Infrastructure\Factories;
use iRESTful\Rodson\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteObjectConfigurationNamespaceFactory implements NamespaceFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $name = $this->baseNamespace[count($this->baseNamespace) - 1].'ObjectConfiguration';
        $merged = array_merge($this->baseNamespace, ['Infrastructure', 'Configurations', $name]);
        return new ConcreteNamespace($merged);
    }

}
