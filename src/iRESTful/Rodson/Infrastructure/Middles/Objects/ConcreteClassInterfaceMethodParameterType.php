<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\ClassNamespace;

final class ConcreteClassInterfaceMethodParameterType implements Type {
    private $isArray;
    private $namespace;
    private $primitive;
    public function __construct($isArray, ClassNamespace $namespace = null, $primitive = null) {

        if (empty($primitive)) {
            $primitive = null;
        }

        $this->isArray = (bool) $isArray;
        $this->namespace = $namespace;
        $this->primitive = $primitive;
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

    public function hasPrimitive() {
        return !empty($this->primitive);
    }

    public function getPrimitive() {
        return $this->primitive;
    }

}
