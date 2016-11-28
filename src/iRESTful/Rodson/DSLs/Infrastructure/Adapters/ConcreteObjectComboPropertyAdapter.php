<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteObjectComboProperty;

final class ConcreteObjectComboPropertyAdapter implements PropertyAdapter {

    public function __construct() {

    }

    public function fromDataToProperty(array $data) {

        if (!isset($data['object_properties'])) {
            throw new PropertyException('The object_properties keyname is mandatory in order to convert data to a Property object.');
        }

        if (!isset($data['command'])) {
            throw new PropertyException('The command keyname is mandatory in order to convert data to a Property object.');
        }

        $isDefault = (strpos(strrev($data['command']), '+') === 0);
        if ($isDefault) {
            $data['command'] = substr($data['command'], 0, strlen($data['command']) - 1);
        }

        $properties = [];
        $propertyNames = explode('&', $data['command']);
        foreach($propertyNames as $onePropertyName) {
            foreach($data['object_properties'] as $oneObjectProperty) {
                if ($oneObjectProperty->getName() == $onePropertyName) {
                    $properties[] = $oneObjectProperty;
                }
            }

        }

        return new ConcreteObjectComboProperty($properties, $isDefault);

    }

}
