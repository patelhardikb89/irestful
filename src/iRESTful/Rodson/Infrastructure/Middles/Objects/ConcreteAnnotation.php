<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Annotations\Exceptions\AnnotationException;

final class ConcreteAnnotation implements Annotation {
    private $parameters;
    private $containerName;
    public function __construct(array $parameters, $containerName = null) {

        if (empty($containerName)) {
            $containerName = '';
        }

        if (empty($parameters)) {
            throw new AnnotationException('There must be at least 1 Parameter object.');
        }

        if (!empty($parameters)) {
            foreach($parameters as $oneParameter) {
                if (!($oneParameter instanceof Parameter)) {
                    throw new AnnotationException('The parameters array must only contain Parameter objects.');
                }
            }
        }

        if (!empty($containerName) && !is_string($containerName)) {
            throw new AnnotationException('The containerName must be a string if non-empty.');
        }

        $this->parameters = $parameters;
        $this->containerName = $containerName;

    }

    public function getParameters() {
        return $this->parameters;
    }

    public function hasContainerName() {
        return !empty($this->containerName);
    }

    public function getContainerName() {
        return $this->containerName;
    }

}
