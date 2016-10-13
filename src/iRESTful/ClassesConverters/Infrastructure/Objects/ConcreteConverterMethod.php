<?php
namespace iRESTful\ClassesConverters\Infrastructure\Objects;
use iRESTful\ClassesConverters\Domain\Methods\Method;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Interfaces\Methods\Parameters\Parameter;

final class ConcreteConverterMethod implements Method {
    private $name;
    private $parameter;
    private $namespace;
    public function __construct($name, Parameter $parameter, ClassNamespace $namespace) {
        $this->name = $name;
        $this->parameter = $parameter;
        $this->namespace = $namespace;
    }

    public function getName() {
        return $this->name;
    }

    public function getParameter() {
        return $this->parameter;
    }

    public function getNamespace() {
        return $this->namespace;
    }

}
