<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Parameters\Parameter;

final class ConcreteClassInterfaceMethod implements Method {
    private $name;
    private $parameters;
    public function __construct($name, array $parameters = null) {

        if (empty($parameters)) {
            $parameters = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new MethodException('The name must be a non-empty string.');
        }

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new MethodException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        $this->name = $name;
        $this->parameters = $parameters;

    }

    public function getName() {
        return $this->name;
    }

    public function hasParameters() {
        return !empty($this->parameters);
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function getData() {
        $output = [
            'name' => $this->getName()
        ];

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
