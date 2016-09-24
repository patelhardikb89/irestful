<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Nodes\ControllerNode;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Configurations\Controllers\Nodes\Exceptions\ControllerNodeException;

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

    public function getData() {

        $controllers = $this->getControllers();
        array_walk($controllers, function(&$element, $index) {
            $element = $element->getData();
        });

        $output = [
            'controllers' => $controllers
        ];

        if ($this->hasNamespaces()) {
            $namespaces = $this->getNamespaces();
            array_walk($namespaces, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['namespaces'] = $namespaces;
        }

        if ($this->hasParameters()) {
            $parameters = $this->getParameters();
            array_walk($parameters, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['parameters'] = $parameters;
        }

        return $output;
    }

}
