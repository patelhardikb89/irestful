<?php
namespace iRESTful\Rodson\ClassesObjectsAnnotations\Infrastructure\Objects;
use iRESTful\Rodson\ClassesObjectsAnnotations\Domain\AnnotatedObject;
use iRESTful\Rodson\ClassesObjects\Domain\Object;
use iRESTful\Rodson\Annotations\Domain\Parameters\Parameter;
use iRESTful\Rodson\ClassesObjectsAnnotations\Domain\Exceptions\AnnotatedObjectException;

final class ConcreteAnnotatedObject implements AnnotatedObject {
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

}
