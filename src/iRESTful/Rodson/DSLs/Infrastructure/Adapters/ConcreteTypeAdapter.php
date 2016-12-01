<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Adapters;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Objects\ConcreteType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Exceptions\TypeException;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Methods\Exceptions\MethodException;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteTypeAdapter implements TypeAdapter {
    private $databaseTypeAdapter;
    private $methodAdapter;
    private $converters;
    public function __construct(DatabaseTypeAdapter $databaseTypeAdapter, MethodAdapter $methodAdapter, array $converters) {
        $this->databaseTypeAdapter = $databaseTypeAdapter;
        $this->methodAdapter = $methodAdapter;
        $this->converters = $converters;
    }

    public function fromDataToValidTypes(array $data) {
        return $this->convertMultipleDataToTypes($data, false);
    }

    public function fromDataToTypes(array $data) {
        return $this->convertMultipleDataToTypes($data, true);
    }

    private function convertMultipleDataToTypes(array $data, $throwException) {
        $output = [];
        foreach($data as $name => $oneData) {

            $oneData['name'] = $name;

            try {

                $output[$name] = $this->fromDataToType($oneData);

            } catch (TypeException $exception) {

                if ($throwException) {
                    throw $exception;
                }

                continue;

            }
        }

        return $output;
    }

    public function fromDataToType(array $data) {

        $converters = $this->converters;
        $getConverter = function($currentTypeName, array $data) use(&$converters) {

            if (!isset($data['from'])) {
                throw new TypeException('The from keyname is mandatory in order to retrieve the converter.');
            }

            if (!isset($data['to'])) {
                throw new TypeException('The to keyname is mandatory in order to retrieve the converter.');
            }

            $keyname = 'from_'.$data['from'].'_to_'.$data['to'];
            if (!isset($converters[$keyname])) {
                throw new TypeException('The converter reference (from: '.$data['from'].', to: '.$data['to'].') does not point to a valid Adapter object.');
            }

            return $converters[$keyname];

        };
        
        if (!isset($data['name'])) {
            throw new TypeException('The name keyname is mandatory in order to convert data to a Type object.');
        }

        if (!isset($data['database_type'])) {
            throw new TypeException('The database_type keyname is mandatory in order to convert data to a Type object.');
        }

        if (!isset($data['converters']['database_to_object'])) {
            throw new TypeException('The converters->database_to_object keyname is mandatory in order to convert data to a Type object.  The name of the Type is: '.$data['name']);
        }

        try {

            $viewAdapter = null;
            if (isset($data['converters']['object_to_view'])) {
                $viewAdapter = $getConverter($data['name'], $data['converters']['object_to_view']);
            }

            $method = null;
            if (isset($data['method'])) {
                $method = $this->methodAdapter->fromStringToMethod($data['method']);
            }

            $databaseAdapter = $getConverter($data['name'], $data['converters']['database_to_object']);
            $databaseType = $this->databaseTypeAdapter->fromDataToDatabaseType($data['database_type']);
            return new ConcreteType($data['name'], $databaseType, $databaseAdapter, $viewAdapter, $method);

        } catch (MethodException $exception) {
            throw new TypeException('There was an exception while converting a string to a Method object.', $exception);
        } catch (DatabaseTypeException $exception) {
            throw new TypeException('There was an exception while converting data to a DatabaseType object.', $exception);
        }
    }

}
