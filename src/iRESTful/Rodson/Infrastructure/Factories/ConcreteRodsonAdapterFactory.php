<?php
namespace iRESTful\Rodson\Infrastructure\Factories;
use iRESTful\Rodson\Domain\Adapters\Factories\RodsonAdapterFactory;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRodsonAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteObjectAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteObjectPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteControllerAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRelationalDatabaseAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseCredentialsAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteRESTAPIAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteTypeAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteCodeMethodAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteViewAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteCodeAdapter;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteCodeLanguageAdapter;
use iRESTful\Rodson\Domain\Inputs\Codes\Code;
use iRESTful\Rodson\Domain\Inputs\Codes\Exceptions\CodeException;
use iRESTful\Rodson\Domain\Inputs\Databases\Exceptions\DatabaseException;
use iRESTful\Rodson\Domain\Inputs\Views\Exceptions\ViewException;
use iRESTful\Rodson\Domain\Inputs\Adapters\Exceptions\AdapterException;
use iRESTful\Rodson\Domain\Inputs\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Exceptions\RodsonException;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteObjectPropertyTypeAdapter;

final class ConcreteRodsonAdapterFactory implements RodsonAdapterFactory {
    private $codeData;
    private $adaptersData;
    private $databasesData;
    private $typesData;
    private $viewsData;
    private $objectsData;
    public function __construct(array $codeData, array $adaptersData, array $databasesData, array $typesData, array $viewsData, array $objectsData) {
        $this->codeData = $codeData;
        $this->adaptersData = $adaptersData;
        $this->databasesData = $databasesData;
        $this->typesData = $typesData;
        $this->viewsData = $viewsData;
        $this->objectsData = $objectsData;
    }

    private function getCode() {
        $languageAdapter = new ConcreteCodeLanguageAdapter();
        $codeAdapter = new ConcreteCodeAdapter($languageAdapter);
        return $codeAdapter->fromDataToCode($this->codeData);
    }

    private function getDatabases() {
        $credentialsAdapter = new ConcreteDatabaseCredentialsAdapter();
        $relationalDatabaseAdapter = new ConcreteRelationalDatabaseAdapter($credentialsAdapter);
        $restAPIAdapter = new ConcreteRESTAPIAdapter($credentialsAdapter);
        $databaseAdapter = new ConcreteDatabaseAdapter($relationalDatabaseAdapter, $restAPIAdapter);
        return $databaseAdapter->fromDataToDatabases($this->databasesData);
    }

    private function getViews(Code $code) {
        $methodAdapter = new ConcreteCodeMethodAdapter($code);
        $viewAdapter = new ConcreteViewAdapter($methodAdapter);
        return $viewAdapter->fromDataToViews($this->viewsData);
    }

    private function getTypes(Code $code) {

        $adaptersData = $this->adaptersData;
        $typesData = $this->typesData;
        $methodAdapter = new ConcreteCodeMethodAdapter($code);

        $getAdapters = function(array $types) use(&$adaptersData, &$methodAdapter) {
            $adapterAdapter = new ConcreteAdapterAdapter($methodAdapter, $types);
            return $adapterAdapter->fromDataToAdapters($adaptersData);
        };

        $getTypeAdapter = function(array $adapters) use(&$methodAdapter) {
            $binaryAdapter = new ConcreteDatabaseTypeBinaryAdapter();
            $floatAdapter = new ConcreteDatabaseTypeFloatAdapter();
            $integerAdapter = new ConcreteDatabaseTypeIntegerAdapter();
            $stringAdapter = new ConcreteDatabaseTypeStringAdapter();
            $databaseTypeAdapter = new ConcreteDatabaseTypeAdapter($binaryAdapter, $floatAdapter, $integerAdapter, $stringAdapter);
            return new ConcreteTypeAdapter($databaseTypeAdapter, $methodAdapter, $adapters);
        };

        $getValidTypes = function() use(&$getTypeAdapter, &$typesData) {
            $typeAdapter = $getTypeAdapter([]);
            return $typeAdapter->fromDataToValidTypes($typesData);
        };

        $getTypes = function(array $adapters) use(&$getTypeAdapter, &$typesData) {
            $typeAdapter = $getTypeAdapter($adapters);
            return $typeAdapter->fromDataToTypes($typesData);
        };

        $types = $getValidTypes();
        $adapters = $getAdapters($types);
        return $getTypes($adapters);
    }

    private function getObjectAdapter(array $types, array $objects) {
        $databases = $this->getDatabases();

        $propertyTypeAdapter = new ConcreteObjectPropertyTypeAdapter($types, $objects);
        $propertyAdapter = new ConcreteObjectPropertyAdapter($propertyTypeAdapter);
        return new ConcreteObjectAdapter($propertyAdapter, $databases);
    }

    private function getObjects(Code $code, array $types) {

        $objects = [];
        $amountObjectsData = count($this->objectsData);
        $amountNewObjects = 0;

        while($amountNewObjects != $amountObjectsData) {
            $objectAdapter = $this->getObjectAdapter($types, $objects);
            $newObjects = $objectAdapter->fromDataToValidObjects($this->objectsData);
            $amountNewObjects = count($newObjects);
            if ($amountNewObjects == count($objects)) {
                break;
            }

            $objects = $newObjects;
        }

        return $objects;

    }

    public function create() {

        try {

            $code = $this->getCode();
            $types = $this->getTypes($code);
            $objects = $this->getObjects($code, $types);
            $views = $this->getViews($code);

            $objectAdapter = $this->getObjectAdapter($types, $objects);
            $controllerAdapter = new ConcreteControllerAdapter($views);
            return new ConcreteRodsonAdapter($objectAdapter, $controllerAdapter);

        } catch (CodeException $exception) {
            throw new RodsonException('There was an exception while converting data to a Code object.', $exception);
        } catch (DatabaseException $exception) {
            throw new RodsonException('There was an exception while converting data to Database objects.', $exception);
        } catch (ViewException $exception) {
            throw new RodsonException('There was an exception while converting data to View objects.', $exception);
        } catch (AdapterException $exception) {
            throw new RodsonException('There was an exception while converting data to Adapter objects.', $exception);
        } catch (TypeException $exception) {
            throw new RodsonException('There was an exception while converting data to Type objects.', $exception);
        }

    }

}
