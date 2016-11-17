<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Objects;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Parameter;
use iRESTful\Rodson\Classes\Domain\Constructors\Exceptions\ConstructorException;

final class ConcreteConstructor implements Constructor {
    private $customMethod;
    private $parameters;
    public function __construct(CustomMethod $customMethod = null, array $parameters = null) {

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new ConstructorException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        $this->customMethod = $customMethod;
        $this->parameters = $parameters;

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

}
