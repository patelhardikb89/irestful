<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Annotations\Annotation;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Annotations\Exceptions\AnnotationException;

final class ConcreteAnnotation implements Annotation {
    private $parameters;
    private $containerName;
    public function __construct($containerName, array $parameters) {

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

        if (empty($containerName) || !is_string($containerName)) {
            throw new AnnotationException('The containerName must be a non-empty string.');
        }

        $this->parameters = $parameters;
        $this->containerName = $containerName;

    }

    public function getContainerName() {
        return $this->containerName;
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function getData() {

        $parameters = $this->getParameters();
        array_walk($parameters, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'container' => $this->getContainerName(),
            'parameters' => $parameters
        ];
    }

}
