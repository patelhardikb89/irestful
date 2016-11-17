<?php
namespace iRESTful\Rodson\ClassesConverters\Infrastructure\Objects;
use iRESTful\Rodson\ClassesConverters\Domain\Methods\Method;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Parameter;

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
