<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethodParameter;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;

final class ConcreteMethodParameterAdapter implements ParameterAdapter {
    private $returnedInterfaceAdapter;
    public function __construct(ReturnedInterfaceAdapter $returnedInterfaceAdapter) {
        $this->returnedInterfaceAdapter = $returnedInterfaceAdapter;
    }

    public function fromDataToParameter(array $data) {

        if (!isset($data['name'])) {
            throw new ParameterException('The name keyname is mandatory in order to convert data to a Parameter objet.');
        }

        return new ConcreteMethodParameter($data['name']);
    }

    public function fromTypeToParameter(Type $type) {

        $convert = function(Type $type) {
            $name = $type->getName();
            return lcfirst($name);
        };

        try {

            $name = $convert($type);
            $interface = $this->returnedInterfaceAdapter->fromTypeToReturnedInterface($type);
            return new ConcreteMethodParameter($name, $interface);

        } catch (ReturnedInterfaceException $exception) {
            throw new ParameterException('There was an exception while converting a Type object to a ReturnedInterface object.', $exception);
        }
    }

    public function fromTypesToParameters(array $types) {
        $output = [];
        foreach($types as $oneType) {
            $output[] = $this->fromTypeToParameter($oneType);
        }

        return $output;
    }

    public function fromPropertyToParameter(Property $property) {

        $convert = function($name) {

            $matches = [];
            preg_match_all('/\_[\s\S]{1}/s', $name, $matches);

            foreach($matches[0] as $oneElement) {
                $replacement = strtoupper(str_replace('_', '', $oneElement));
                $name = str_replace($oneElement, $replacement, $name);
            }

            return lcfirst($name);

        };

        $propertyType = $property->getType();
        $propertyName = $property->getName();

        try {

            $name = $convert($propertyName);
            $returnedInterface = $this->returnedInterfaceAdapter->fromPropertyTypeToReturnedInterface($propertyType);

        } catch (ReturnedInterfaceException $exception) {
            throw new ParameterException('There was an exception while converting a Property Type to a ReturnedInterface.', $exception);
        }

        return new ConcreteMethodParameter($name, $returnedInterface);

    }

    public function fromPropertiesToParameters(array $properties) {
        $output = [];
        foreach($properties as $oneProperty) {
            $output[] = $this->fromPropertyToParameter($oneProperty);
        }

        return $output;
    }

}
