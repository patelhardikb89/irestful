<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Outputs\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Adapters\ReturnedInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteMethod;
use iRESTful\Rodson\Domain\Outputs\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Property;
use iRESTful\Rodson\Domain\Inputs\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Outputs\Methods\Returns\Exceptions\ReturnedInterfaceException;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Domain\Outputs\Methods\Parameters\Exceptions\ParameterException;

final class ConcreteMethodAdapter implements MethodAdapter {
    private $returnedInterfaceAdapter;
    private $parameterAdapter;
    public function __construct(ReturnedInterfaceAdapter $returnedInterfaceAdapter, ParameterAdapter $parameterAdapter) {
        $this->returnedInterfaceAdapter = $returnedInterfaceAdapter;
        $this->parameterAdapter = $parameterAdapter;
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

        $parameters = null;
        if (isset($data['parameters'])) {
            $parameters = $data['parameters'];
        }

        return new ConcreteMethod($data['name'], null, $parameters);

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

        try {

            $propertyName = $property->getName();
            $name = $convert($propertyName);
            $type = $property->getType();
            $returnedType = $this->returnedInterfaceAdapter->fromPropertyTypeToReturnedInterface($type);

            return new ConcreteMethod($name, $returnedType);

        } catch (ReturnedInterfaceException $exception) {
            throw new MethodException('There was an exception while converting a PropertyType object to a ReturnedInterface object.', $exception);
        }

    }

    public function fromTypeToMethods(Type $type) {

        $getMethod = function(Type $type, Adapter $adapter) {

            $typeName = $type->getName();

            $fromType = $typeName;
            $parameterType = null;
            if ($adapter->hasFromType()) {
                $parameterType = $adapter->fromType();
                $fromType = $parameterType->getName();
            }

            $toType = $typeName;
            $returnedType = null;
            if ($adapter->hasToType()) {
                $returnedType = $adapter->toType();
                $toType = $returnedType->getName();
            }

            if (empty($returnedType)) {
                $returnedType = $type;
            }

            if (empty($parameterType)) {
                $parameterType = $type;
            }

            $methodName = 'from'.ucfirst($fromType).'To'.ucfirst($toType);
            $returnedInterface = $this->returnedInterfaceAdapter->fromTypeToReturnedInterface($returnedType);

            $parameters = [
                $this->parameterAdapter->fromTypeToParameter($parameterType)
            ];

            return new ConcreteMethod($methodName, $returnedInterface, $parameters);


        };

        try {

            $output = [];
            if ($type->hasDatabaseAdapter()) {
                $databaseAdapter = $type->getDatabaseAdapter();
                $output[] = $getMethod($type, $databaseAdapter);
            }

            if ($type->hasViewAdapter()) {
                $viewAdapter = $type->getViewAdapter();
                $output[] = $getMethod($type, $viewAdapter);
            }

            return $output;

        } catch (ParameterException $exception) {
            throw new MethodException('There was an exception while converting a Type object to a Parameter object.', $exception);
        } catch (ReturnedInterfaceException $exception) {
            throw new MethodException('There was an exception while converting a Type object to a ReturnedInterface object.', $exception);
        }

    }

}
