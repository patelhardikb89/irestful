<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Types\Type;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\DSLs\Domain\Projects\Primitives\Primitive;

final class ConcreteInterfaceMethodParameterType implements Type {
    private $isArray;
    private $namespace;
    private $primitive;
    public function __construct($isArray, ClassNamespace $namespace = null, Primitive $primitive = null) {
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

    public function getData() {

        $output = [
            'is_array' => $this->isArray()
        ];

        if ($this->hasNamespace()) {
            $output['namespace'] = $this->getNamespace()->getData();
        }

        if ($this->hasPrimitive()) {
            $output['primitive'] = $this->getPrimitive();
        }

        return $output;
    }

}
