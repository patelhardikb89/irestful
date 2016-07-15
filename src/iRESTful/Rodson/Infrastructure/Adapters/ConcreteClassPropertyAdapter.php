<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Classes\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property as ObjectProperty;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteClassProperty;

final class ConcreteClassPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }
    
    public function fromObjectToProperties(Object $object) {

        $properties = [];
        $objectProperties = $object->getProperties();
        foreach($objectProperties as $oneObjectProperty) {
            $properties[] = $this->fromObjectPropertyToProperty($oneObjectProperty);
        }

        return $properties;

    }

    public function fromObjectPropertyToProperty(ObjectProperty $objectProperty) {

        $convert = function($name) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return lcfirst($name);

        };

        $objectPropertyName = $objectProperty->getName();
        $name = $convert($objectPropertyName);
        return new ConcreteClassProperty($name);
    }

}
