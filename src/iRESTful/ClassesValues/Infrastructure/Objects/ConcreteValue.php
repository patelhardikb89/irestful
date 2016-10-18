<?php
namespace iRESTful\ClassesValues\Infrastructure\Objects;
use iRESTful\ClassesValues\Domain\Value;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Classes\Domain\Constructors\Constructor;
use iRESTful\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\ClassesConverters\Domain\Converter;

final class ConcreteValue implements Value {
    private $type;
    private $converter;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethod;
    public function __construct(
        Type $type,
        Converter $converter,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor,
        CustomMethod $customMethod = null
    ) {
        $this->type = $type;
        $this->converter = $converter;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->customMethod = $customMethod;
    }

    public function getType() {
        return $this->type;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getInterface() {
        return $this->interface;
    }

    public function getConstructor() {
        return $this->constructor;
    }

    public function getConverter() {
        return $this->converter;
    }

    public function hasCustomMethod() {
        return !empty($this->customMethod);
    }

    public function getCustomMethod() {
        return $this->customMethod;
    }

}
