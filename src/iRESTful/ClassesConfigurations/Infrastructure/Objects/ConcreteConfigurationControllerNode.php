<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Objects;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\ControllerNode;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Constructors\Parameters\Parameter;
use iRESTful\ClassesConfigurations\Domain\Controllers\Controller;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Exceptions\ControllerNodeException;

final class ConcreteConfigurationControllerNode implements ControllerNode {
    private $controllers;
    private $namespaces;
    private $parameters;
    public function __construct(array $controllers, array $namespaces = null, array $parameters = null) {

        if (empty($namespaces)) {
            $namespaces = null;
        }

        if (empty($parameters)) {
            $parameters = null;
        }

        if (empty($controllers)) {
            throw new ControllerNodeException('The controllers array cannot be empty.');
        }

        if (!empty($namespaces)) {
            foreach($namespaces as $oneNamespace) {
                if (!($oneNamespace instanceof ClassNamespace)) {
                    throw new ControllerNodeException('The namespaces array must only contain ClassNamespace objects.');
                }
            }
        }

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new ControllerNodeException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        foreach($controllers as $oneController) {
            if (!($oneController instanceof Controller)) {
                throw new ControllerNodeException('The controllers array must only contain Controller objects.');
            }
        }

        $this->controllers = $controllers;
        $this->namespaces = $namespaces;
        $this->parameters = $parameters;

    }

    public function getControllers() {
        return $this->controllers;
    }

    public function hasNamespaces() {
        return !empty($this->namespaces);
    }

    public function getNamespaces() {
        return $this->namespaces;
    }

    public function hasParameters() {
        return !empty($this->parameters);
    }

    public function getParameters() {
        return $this->parameters;
    }

}
