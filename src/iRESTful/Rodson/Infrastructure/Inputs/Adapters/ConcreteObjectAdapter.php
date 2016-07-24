<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteObject;
use iRESTful\Rodson\Domain\Inputs\Objects\Exceptions\ObjectException;
use iRESTful\Rodson\Domain\Inputs\Objects\Properties\Exceptions\PropertyException;
use iRESTful\Rodson\Domain\Inputs\Objects\Adapters\ObjectAdapter;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Inputs\Objects\Methods\Adapters\MethodAdapter;

final class ConcreteObjectAdapter implements ObjectAdapter {
    private $methodAdapter;
    private $propertyAdapter;
    private $databases;
    public function __construct(MethodAdapter $methodAdapter, PropertyAdapter $propertyAdapter, array $databases) {
        $this->methodAdapter = $methodAdapter;
        $this->propertyAdapter = $propertyAdapter;
        $this->databases = $databases;
    }

    public function fromDataToValidObjects(array $data) {
        return $this->convertMultipleDataToObjects($data, false);
    }

    public function fromDataToObjects(array $data) {
        return $this->convertMultipleDataToObjects($data, true);
    }

    public function fromDataToObject(array $data) {

        if (!isset($data['name'])) {
            throw new ObjectException('The name keyname is mandatory in order to convert data to an Object object.');
        }

        if (!isset($data['properties'])) {
            throw new ObjectException('The properties keyname is mandatory in order to convert data to Property objects.');
        }

        try {

            $database = null;
            if (isset($data['database'])) {

                if (!isset($this->databases[$data['database']])) {
                    throw new ObjectException('The referenced database ('.$data['database'].') does not exists.');
                }

                $database = $this->databases[$data['database']];
            }

            $methods = null;
            if (isset($data['methods'])) {
                $methods = $this->methodAdapter->fromDataToMethods($data['methods']);
            }

            $properties = $this->propertyAdapter->fromDataToProperties($data['properties']);
            return new ConcreteObject($data['name'], $properties, $database, $methods);

        } catch (PropertyException $exception) {
            throw new ObjectException('There was an exception while converting data to Property objects.', $exception);
        }
    }

    private function convertMultipleDataToObjects(array $data, $throwException) {
        $output = [];
        foreach($data as $name => $oneData) {

            try {

                $oneData['name'] = $name;
                $output[$name] = $this->fromDataToObject($oneData);

            } catch (ObjectException $exception) {

                if ($throwException) {
                    throw $exception;
                }

                continue;

            }
        }

        return $output;
    }

}
