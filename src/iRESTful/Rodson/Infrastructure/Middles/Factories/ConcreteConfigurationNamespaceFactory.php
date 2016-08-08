<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteNamespace;

final class ConcreteConfigurationNamespaceFactory implements NamespaceFactory {
    private $baseNamespace;
    private $name;
    public function __construct(array $baseNamespace, $name) {
        $this->baseNamespace = $baseNamespace;
        $this->name = $name;
    }

    public function create() {
        $merged = array_merge($this->baseNamespace, ['Infrastructure', 'Configurations', $this->name.'Configuration']);
        return new ConcreteNamespace($merged);
    }

}
