<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteInterfaceMethod;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Exceptions\MethodException;

final class ConcreteInterfaceMethodAdapter implements MethodAdapter {

    public function __construct() {

    }

    public function fromDataToMethods(array $data) {
        $output = [];
        foreach($data as $oneData) {
            $output[] = $this->fromDataToMethod($oneData);
        }

        return $output;
    }

    public function fromDataToMethod(array $data) {

        if (!isset($data['name'])) {
            throw new MethodException('The name keyname is mandatory in order to convert data to a Method object.');
        }

        return new ConcreteInterfaceMethod($data['name']);

    }

    public function fromPropertiesToMethods(array $properties) {

        $methods = [];
        foreach($properties as $oneProperty) {
            $methods[] = $this->fromPropertyToMethod($oneProperty);
        }

        return $methods;

    }

    public function fromPropertyToMethod(Property $property) {

        $convert = function($name) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return 'get'.ucfirst($name);

        };

        $name = $convert($property->getName());
        $type = $property->getType();
        return new ConcreteInterfaceMethod($name, $type);

    }

}
