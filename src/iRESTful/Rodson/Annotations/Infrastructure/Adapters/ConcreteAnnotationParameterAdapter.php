<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Adapters;
use iRESTful\Rodson\Annotations\Domain\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Annotations\Domain\Parameters\Flows\Adapters\FlowAdapter;
use iRESTful\Rodson\Classes\Domain\Properties\Property;
use iRESTful\Rodson\Annotations\Domain\Parameters\Converters\Adapters\ConverterAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Objects\ConcreteAnnotationParameter;
use iRESTful\Rodson\Classes\Domain\Constructors\Parameters\Parameter as ConstructorParameter;
use iRESTful\Rodson\Annotations\Domain\Parameters\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Annotations\Domain\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object as InputObject;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;
use iRESTful\Rodson\ClassesObjects\Domain\Object;

final class ConcreteAnnotationParameterAdapter implements ParameterAdapter {
    private $flowAdapter;
    private $converterAdapter;
    private $typeAdapter;
    public function __construct(
        FlowAdapter $flowAdapter,
        ConverterAdapter $converterAdapter,
        TypeAdapter $typeAdapter
    ) {
        $this->flowAdapter = $flowAdapter;
        $this->converterAdapter = $converterAdapter;
        $this->typeAdapter = $typeAdapter;
    }

    public function fromEntityToParameters(Entity $entity) {
        $constructor = $entity->getConstructor();
        if (!$constructor->hasParameters()) {
            throw new ParameterException('The given entity does not have parameters to its constructor.  Therefore, does not have AnnotationParameter objects.');
        }

        $object = $entity->getEntity()->getObject();
        $parameters = $entity->getConstructor()->getParameters();
        foreach($parameters as $oneParameter) {

            $oneOutput = $this->fromConstructorParameterToParameter($oneParameter, $object);
            if (!empty($oneOutput)) {
                $output[] = $oneOutput;
            }

        }

        return $output;

    }

    public function fromObjectToParameters(Object $object) {
        $constructor = $object->getConstructor();
        if (!$constructor->hasParameters()) {
            throw new ParameterException('The given object does not have parameters to its constructor.  Therefore, does not have AnnotationParameter objects.');
        }

        $inputObject = $object->getObject();
        $parameters = $object->getConstructor()->getParameters();
        foreach($parameters as $oneParameter) {

            $oneOutput = $this->fromConstructorParameterToParameter($oneParameter, $inputObject);
            if (!empty($oneOutput)) {
                $output[] = $oneOutput;
            }

        }

        return $output;

    }

    private function fromConstructorParameterToParameter(ConstructorParameter $constructorParameter, InputObject $object) {

        $fromClassPropertyToObjectProperty = function(Property $property) use(&$object) {

            $convert = function($name) {

                $matches = [];
                preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

                foreach($matches[0] as $oneElement) {
                    $replacement = strtoupper(str_replace('_', '', $oneElement));
                    $name = str_replace($oneElement, $replacement, $name);
                }

                return lcfirst($name);

            };

            $propertyName = $property->getName();
            $objectProperties = $object->getProperties();
            foreach($objectProperties as $oneObjectProperty) {
                $objectPropertyName = $convert($oneObjectProperty->getName());
                if ($propertyName == $objectPropertyName) {
                    return $oneObjectProperty;
                }
            }

            //throws

        };

        $classProperty = $constructorParameter->getProperty();
        $objectProperty = $fromClassPropertyToObjectProperty($classProperty);
        $objectPropertyType = $objectProperty->getType();
        $type = $this->typeAdapter->fromObjectPropertyToType($objectProperty);

        $converter = null;
        if ($objectPropertyType->hasType()) {
            $objectPropertyTypeType = $objectPropertyType->getType();
            $converter = $this->converterAdapter->fromTypeToConverter($objectPropertyTypeType);
        }

        $elementsType = null;
        if ($objectPropertyType->isArray()) {
            $constructorParameterType = $constructorParameter->getParameter()->getType();
            if ($constructorParameterType->hasNamespace()) {
                $elementsType = $constructorParameterType->getNamespace()->getAllAsString();
            }
        }

        $flow = $this->flowAdapter->fromConstructorParameterToFlow($constructorParameter);
        return new ConcreteAnnotationParameter($flow, $type, $converter, $elementsType);
    }

}
