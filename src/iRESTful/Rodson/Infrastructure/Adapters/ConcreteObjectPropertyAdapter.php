<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteObjectProperty;
use iRESTful\Rodson\Domain\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectPropertyAdapter implements PropertyAdapter {
    private $types;
    public function __construct(array $types) {
        $this->types = $types;
    }

    public function fromDataToProperties(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToProperty($oneData);
        }

        return $output;
    }

    public function fromDataToProperty(array $data) {

        if (!isset($data['name'])) {
            throw new PropertyException('The name keyname is mandatory in order to convert dat to a Property object.');
        }

        if (!isset($data['type'])) {
            throw new PropertyException('The type keyname is mandatory in order to convert dat to a Property object.');
        }

        if (!isset($this->types[$data['type']])) {
            throw new PropertyException('The type ('.$data['type'].') reference does not point to a valid type.');
        }

        $type = $this->types[$data['type']];
        return new ConcreteObjectProperty($data['name'], $type);
    }

}
