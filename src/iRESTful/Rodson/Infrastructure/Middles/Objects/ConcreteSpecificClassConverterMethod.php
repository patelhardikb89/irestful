<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Parameter;

final class ConcreteSpecificClassConverterMethod implements Method {
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

    public function getData() {
        return [
            'name' => $this->name,
            'parameter' => $this->getParameter()->getData(),
            'namespace' => $this->getNamespace()->getData()
        ];
    }

}
