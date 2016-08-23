<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Exceptions\ConstructorException;

final class ConcreteClassConstructor implements Constructor {
    private $name;
    private $customMethod;
    private $parameters;
    public function __construct($name, CustomMethod $customMethod = null, array $parameters = null) {

        if (empty($name) || !is_string($name)) {
            throw new ConstructorException('The name must be a non-empty string.');
        }

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new ConstructorException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        $this->name = $name;
        $this->customMethod = $customMethod;
        $this->parameters = $parameters;

    }

    public function getName() {
        return $this->name;
    }

    public function hasCustomMethod() {
        return $this->customMethod;
    }

    public function getCustomMethod() {
        return $this->customMethod;
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

        if ($this->hasCustomMethod()) {
            $output['custom_method'] = $this->getCustomMethod()->getData();
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
