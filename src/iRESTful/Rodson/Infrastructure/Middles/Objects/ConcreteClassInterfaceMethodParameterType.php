<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\ClassNamespace;

final class ConcreteClassInterfaceMethodParameterType implements Type {
    private $isArray;
    private $namespace;
    public function __construct($isArray, ClassNamespace $namespace = null) {
        $this->isArray = (bool) $isArray;
        $this->namespace = $namespace;
    }

    public function isArray() {
        return $this->isArray;
    }

    public function hasNamespace() {
        return !empty($this->namespace);
    }

    public function getNamespace() {
        return $this->namespace;
    }

}
