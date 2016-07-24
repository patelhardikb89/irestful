<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Adapters;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Objects\ConcreteType;
use iRESTful\Rodson\Domain\Inputs\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Inputs\Codes\Methods\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteTypeAdapter implements TypeAdapter {
    private $databaseTypeAdapter;
    private $methodAdapter;
    private $adapters;
    public function __construct(DatabaseTypeAdapter $databaseTypeAdapter, MethodAdapter $methodAdapter, array $adapters) {
        $this->databaseTypeAdapter = $databaseTypeAdapter;
        $this->methodAdapter = $methodAdapter;
        $this->adapters = $adapters;
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

        $adapters = $this->adapters;
        $getAdapter = function($currentTypeName, array $data) use(&$adapters) {

            if (!isset($data['from'])) {
                throw new TypeException('The from keyname is mandatory in order to retrieve the adapter.');
            }

            if (!isset($data['to'])) {
                throw new TypeException('The to keyname is mandatory in order to retrieve the adapter.');
            }

            $keyname = 'from_'.$data['from'].'_to_'.$data['to'];
            if (!isset($adapters[$keyname])) {
                throw new TypeException('The adapter reference (from: '.$data['from'].', to: '.$data['to'].') does not point to a valid Adapter object.');
            }

            return $adapters[$keyname];

        };

        if (!isset($data['name'])) {
            throw new TypeException('The name keyname is mandatory in order to convert data to a Type object.');
        }

        if (!isset($data['database_type'])) {
            throw new TypeException('The database_type keyname is mandatory in order to convert data to a Type object.');
        }

        try {

            $databaseAdapter = null;
            if (isset($data['adapters']['database_to_object'])) {
                $databaseAdapter = $getAdapter($data['name'], $data['adapters']['database_to_object']);
            }

            $viewAdapter = null;
            if (isset($data['adapters']['object_to_view'])) {
                $viewAdapter = $getAdapter($data['name'], $data['adapters']['object_to_view']);
            }

            $method = null;
            if (isset($data['method'])) {
                $method = $this->methodAdapter->fromStringToMethod($data['method']);
            }

            $databaseType = $this->databaseTypeAdapter->fromDataToDatabaseType($data['database_type']);
            return new ConcreteType($data['name'], $databaseType, $databaseAdapter, $viewAdapter, $method);

        } catch (MethodException $exception) {
            throw new TypeException('There was an exception while converting a string to a Method object.', $exception);
        } catch (DatabaseTypeException $exception) {
            throw new TypeException('There was an exception while converting data to a DatabaseType object.', $exception);
        }
    }

}
