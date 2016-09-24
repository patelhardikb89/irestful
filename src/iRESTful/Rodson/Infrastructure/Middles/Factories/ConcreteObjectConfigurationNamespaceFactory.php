<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;

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
