<?php
namespace iRESTful\DSLs\Infrastructure\Adapters;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Adapters\PropertyAdapter;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteObject;
use iRESTful\DSLs\Domain\Projects\Objects\Exceptions\ObjectException;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Exceptions\PropertyException;
use iRESTful\DSLs\Domain\Projects\Objects\Adapters\ObjectAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\DSLs\Domain\Projects\Objects\Methods\Adapters\MethodAdapter;

final class ConcreteObjectAdapter implements ObjectAdapter {
    private $methodAdapter;
    private $propertyAdapter;
    private $databases;
    private $parents;
    public function __construct(
        MethodAdapter $methodAdapter,
        PropertyAdapter $propertyAdapter,
        array $databases,
        array $parents
    ) {
        $this->methodAdapter = $methodAdapter;
        $this->propertyAdapter = $propertyAdapter;
        $this->databases = $databases;
        $this->parents = $parents;
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

            $properties = $this->propertyAdapter->fromDataToProperties([
                'properties' => $data['properties'],
                'parents' => $this->parents
            ]);

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
