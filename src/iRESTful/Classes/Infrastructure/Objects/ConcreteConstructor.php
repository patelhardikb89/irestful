<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\Constructors\Constructor;
use iRESTful\Classes\Domain\Methods\Customs\CustomMethod;
use iRESTful\Classes\Domain\Constructors\Parameters\Parameter;
use iRESTful\Classes\Domain\Constructors\Exceptions\ConstructorException;

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
