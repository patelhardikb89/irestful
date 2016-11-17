<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Objects;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Exceptions\CustomMethodException;
use iRESTful\Rodson\Classes\Domain\Interfaces\Methods\Parameters\Parameter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\SourceCodes\SourceCode;

final class ConcreteCustomMethod implements CustomMethod {
    private $name;
    private $sourceCode;
    private $parameters;
    public function __construct($name, SourceCode $sourceCode, array $parameters = null) {

        if (empty($name) || !is_string($name)) {
            throw new CustomMethodException('The name must be a non-empty string.');
        }

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new CustomMethodException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        $this->name = $name;
        $this->sourceCode = $sourceCode;
        $this->parameters = $parameters;

    }

    public function getName() {
        return $this->name;
    }

    public function getSourceCode() {
        return $this->sourceCode;
    }

    public function hasParameters() {
        return !empty($this->parameters);
    }

    public function getParameters() {
        return $this->parameters;
    }

}
