<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\AnnotatedObject;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Parameter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\Exceptions\AnnotatedObjectException;

final class ConcreteSpecificClassObjectAnnotated implements AnnotatedObject {
    private $object;
    private $parameters;
    public function __construct(Object $object, array $parameters) {

        if (empty($parameters)) {
            throw new AnnotatedObjectException('The parameters array cannot be empty.');
        }

        foreach($parameters as $oneParameter) {
            if (!($oneParameter instanceof Parameter)) {
                throw new AnnotatedObjectException('The parameters array must only contain Parameter objects.');
            }
        }

        $this->object = $object;
        $this->parameters = $parameters;

    }

    public function getObject() {
        return $this->object;
    }

    public function getAnnotationParameters() {
        return $this->parameters;
    }

    public function getData() {

        $parameters = $this->getAnnotationParameters();
        array_walk($parameters, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'object' => $this->object->getData(),
            'annotation_parameters' => $parameters
        ];
    }

}
