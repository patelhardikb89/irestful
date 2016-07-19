<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethodParameter;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;

final class ConcreteMethodParameterAdapter implements ParameterAdapter {
    private $returnedInterfaceAdapter;
    public function __construct(ReturnedInterfaceAdapter $returnedInterfaceAdapter) {
        $this->returnedInterfaceAdapter = $returnedInterfaceAdapter;
    }

    public function fromDataToParameter(array $data) {

        if (!isset($data['name'])) {
            throw new ParameterException('The name keyname is mandatory in order to convert data to a Parameter objet.');
        }

        return new ConcreteMethodParameter($data['name'], false, false);
    }

    public function fromTypeToParameter(Type $type) {

        $convert = function(Type $type) {
            $name = $type->getName();
            return lcfirst($name);
        };

        try {

            $name = $convert($type);
            $interface = $this->returnedInterfaceAdapter->fromTypeToReturnedInterface($type);
            return new ConcreteMethodParameter($name, false, false, $interface);

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
        $isArray = $propertyType->isArray();

        try {

            $name = $convert($propertyName);
            $returnedInterface = $this->returnedInterfaceAdapter->fromPropertyTypeToReturnedInterface($propertyType);

            return new ConcreteMethodParameter($name, false, $isArray, $returnedInterface);

        } catch (ReturnedInterfaceException $exception) {
            throw new ParameterException('There was an exception while converting a Property Type to a ReturnedInterface.', $exception);
        }

    }

    public function fromPropertiesToParameters(array $properties) {
        $output = [];
        foreach($properties as $oneProperty) {
            $output[] = $this->fromPropertyToParameter($oneProperty);
        }

        return $output;
    }



    public function fromObjectToParameters(Object $object) {

        $entityParameters = [];
        if ($object->hasDatabase()) {
            $interfaces = $this->returnedInterfaceAdapter->fromDataToReturnedInterfaces([
                ['name' => 'Uuid', 'namespace' => 'iRESTful\Objects\Libraries\Ids\Domain\Uuids\Uuid'],
                ['name' => '\DateTime', 'namespace' => '\DateTime']
            ]);

            $names = ['uuid', 'createdOn'];
            foreach($interfaces as $index => $oneInterface) {
                $entityParameters[] = new ConcreteMethodParameter($names[$index], true, false, $oneInterface);
            }
        }

        $properties = $object->getProperties();
        $parameters = $this->fromPropertiesToParameters($properties);
        return array_merge($entityParameters, $parameters);

    }

}
