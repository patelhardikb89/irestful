<?php
namespace iRESTful\Rodson\ClassesApplications\Infrastructure\Factories;
use iRESTful\Rodson\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\Classes\Infrastructure\Objects\ConcreteNamespace;

final class ConcreteApplicationNamespaceFactory implements NamespaceFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $name = $this->baseNamespace[count($this->baseNamespace) - 1].'Application';
        $merged = array_merge($this->baseNamespace, ['Infrastructure', 'Applications', $name]);
        return new ConcreteNamespace($merged);
    }

}
