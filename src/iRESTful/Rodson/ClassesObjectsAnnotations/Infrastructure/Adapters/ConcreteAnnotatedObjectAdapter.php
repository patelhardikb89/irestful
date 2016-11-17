<?php
namespace iRESTful\Rodson\ClassesObjectsAnnotations\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesObjectsAnnotations\Domain\Adapters\AnnotatedObjectAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\ClassesObjects\Domain\Adapters\ObjectAdapter;
use iRESTful\Rodson\ClassesObjectsAnnotations\Infrastructure\Objects\ConcreteAnnotatedObject;
use iRESTful\Rodson\Annotations\Domain\Parameters\Adapters\ParameterAdapter;

final class ConcreteAnnotatedObjectAdapter implements AnnotatedObjectAdapter {
    private $objectAdapter;
    private $parameterAdapter;
    public function __construct(ObjectAdapter $objectAdapter, ParameterAdapter $parameterAdapter) {
        $this->objectAdapter = $objectAdapter;
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromDSLObjectsToAnnotatedClassObjects(array $objects) {
        $output = [];
        foreach($objects as $oneObject) {

            if ($oneObject->hasDatabase()) {
                continue;
            }

            $output[] = $this->fromDSLObjectToAnnotatedClassObject($oneObject);
        }

        return $output;
    }

    public function fromDSLObjectToAnnotatedClassObject(Object $inputObject) {
        $object = $this->objectAdapter->fromDSLObjectToObject($inputObject);
        $parameters = $this->parameterAdapter->fromObjectToParameters($object);
        return new ConcreteAnnotatedObject($object, $parameters);
    }

}
