<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Annotations\Adapters\AnnotatedObjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassObjectAnnotated;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Adapters\ParameterAdapter;

final class ConcreteSpecificClassObjectAnnotatedAdapter implements AnnotatedObjectAdapter {
    private $objectAdapter;
    private $parameterAdapter;
    public function __construct(ObjectAdapter $objectAdapter, ParameterAdapter $parameterAdapter) {
        $this->objectAdapter = $objectAdapter;
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromObjectsToAnnotatedObjects(array $objects) {
        $output = [];
        foreach($objects as $oneObject) {

            if ($oneObject->hasDatabase()) {
                continue;
            }

            $output[] = $this->fromObjectToAnnotatedObject($oneObject);
        }

        return $output;
    }

    private function fromObjectToAnnotatedObject(Object $inputObject) {
        $object = $this->objectAdapter->fromObjectToObject($inputObject);
        $parameters = $this->parameterAdapter->fromObjectToParameters($object);
        return new ConcreteSpecificClassObjectAnnotated($object, $parameters);
    }

}
