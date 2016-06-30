<?php
namespace iRESTful\Rodson\Infrastructure\Adapters;
use iRESTful\Rodson\Domain\Types\Adapters\TypeAdapter;
use iRESTful\Rodson\Domain\Types\Databases\Adapters;
use iRESTful\Rodson\Domain\Types\Databases\Adapters\DatabaseTypeAdapter;
use iRESTful\Rodson\Domain\Codes\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteType;
use iRESTful\Rodson\Domain\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Codes\Exceptions\MethodException;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

//must have indexes.  Have a look at ConcreteAdapterAdapter's code.
final class ConcreteTypeAdapter implements TypeAdapter {
    private $databaseTypeAdapter;
    private $methodAdapter;
    private $adapters;
    public function __construct(DatabaseTypeAdapter $databaseTypeAdapter, MethodAdapter $methodAdapter, array $adapters) {
        $this->databaseTypeAdapter = $databaseTypeAdapter;
        $this->methodAdapter = $methodAdapter;
        $this->adapters = $adapters;
    }

    public function fromDataToTypes(array $data) {
        $output = [];
        foreach($data as $name => $oneData) {
            $oneData['name'] = $name;
            $output[] = $this->fromDataToType($oneData);
        }

        return $output;
    }

    public function fromDataToType(array $data) {

        $adpters = $this->adapters;
        $getAdapter = function(array $data) use(&$adapters) {

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
                $databaseAdapter = $getAdapter($data['adapters']['database_to_object']);
            }

            $viewAdapter = null;
            if (isset($data['adapters']['object_to_view'])) {
                $viewAdapter = $getAdapter($data['adapters']['object_to_view']);
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
