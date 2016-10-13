<?php
namespace iRESTful\DSLs\Infrastructure\Factories;
use iRESTful\DSLs\Domain\Projects\Adapters\Factories\ProjectAdapterFactory;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteProjectAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteObjectAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteObjectPropertyAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteRelationalDatabaseAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseCredentialsAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteRESTAPIAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteTypeAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteCodeMethodAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteConverterAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteCodeAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteCodeLanguageAdapter;
use iRESTful\DSLs\Domain\Projects\Codes\Code;
use iRESTful\DSLs\Domain\Projects\Codes\Exceptions\CodeException;
use iRESTful\DSLs\Domain\Projects\Databases\Exceptions\DatabaseException;
use iRESTful\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;
use iRESTful\DSLs\Domain\Projects\Types\Exceptions\TypeException;
use iRESTful\DSLs\Domain\Projects\Exceptions\ProjectException;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteObjectPropertyTypeAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteObjectMethodAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteConverterTypeAdapter;
use iRESTful\DSLs\Infrastructure\Factories\ConcretePrimitiveFactory;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteObjectSampleAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerHttpRequestAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerHttpRequestCommandAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerHttpRequestCommandActionAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerHttpRequestCommandUrlAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerHttpRequestViewAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteValueAdapterAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerViewTemplateAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteControllerViewAdapter;

final class ConcreteProjectAdapterFactory implements ProjectAdapterFactory {
    private $codeData;
    private $convertersData;
    private $databasesData;
    private $typesData;
    private $objectsData;
    private $baseDirectory;
    public function __construct(
        array $codeData, array $convertersData,
        array $databasesData,
        array $typesData,
        array $objectsData,
        $baseDirectory
    ) {
        $this->codeData = $codeData;
        $this->convertersData = $convertersData;
        $this->databasesData = $databasesData;
        $this->typesData = $typesData;
        $this->objectsData = $objectsData;
        $this->baseDirectory = $baseDirectory;
    }

    private function getCode() {
        $languageAdapter = new ConcreteCodeLanguageAdapter();
        $codeAdapter = new ConcreteCodeAdapter($languageAdapter, $this->baseDirectory);
        return $codeAdapter->fromDataToCode($this->codeData);
    }

    private function getDatabases() {
        $credentialsAdapter = new ConcreteDatabaseCredentialsAdapter();
        $relationalDatabaseAdapter = new ConcreteRelationalDatabaseAdapter($credentialsAdapter);
        $restAPIAdapter = new ConcreteRESTAPIAdapter($credentialsAdapter);
        $databaseAdapter = new ConcreteDatabaseAdapter($relationalDatabaseAdapter, $restAPIAdapter);
        return $databaseAdapter->fromDataToDatabases($this->databasesData);
    }

    private function getConverters(array $types, array $primitives) {
        $converterTypeAdapter = new ConcreteConverterTypeAdapter();
        $converterAdapter = new ConcreteConverterAdapter($converterTypeAdapter, $types, $primitives);
        return $converterAdapter->fromDataToConverters($this->convertersData);
    }

    private function getTypes(Code $code, array $primitives) {

        $typesData = $this->typesData;
        $methodAdapter = new ConcreteCodeMethodAdapter($code);

        $getTypeAdapter = function(array $converters) use(&$methodAdapter) {
            $binaryAdapter = new ConcreteDatabaseTypeBinaryAdapter();
            $floatAdapter = new ConcreteDatabaseTypeFloatAdapter();
            $integerAdapter = new ConcreteDatabaseTypeIntegerAdapter();
            $stringAdapter = new ConcreteDatabaseTypeStringAdapter();
            $databaseTypeAdapter = new ConcreteDatabaseTypeAdapter($binaryAdapter, $floatAdapter, $integerAdapter, $stringAdapter);
            return new ConcreteTypeAdapter($databaseTypeAdapter, $methodAdapter, $converters);
        };

        $getValidTypes = function() use(&$getTypeAdapter, &$typesData) {
            $typeAdapter = $getTypeAdapter([]);
            return $typeAdapter->fromDataToValidTypes($typesData);
        };

        $getTypes = function(array $converters) use(&$getTypeAdapter, &$typesData) {
            $typeAdapter = $getTypeAdapter($converters);
            return $typeAdapter->fromDataToTypes($typesData);
        };

        $types = $getValidTypes();
        $converters = $this->getConverters($types, $primitives);
        return $getTypes($converters);
    }

    private function getObjectAdapter(Code $code, array $types, array $primitives, array $objects) {
        $databases = $this->getDatabases();

        $sampleAdapter = new ConcreteObjectSampleAdapter();
        $methodAdapter = new ConcreteCodeMethodAdapter($code);
        $objectMethodAdapter = new ConcreteObjectMethodAdapter($methodAdapter);

        $propertyTypeAdapter = new ConcreteObjectPropertyTypeAdapter($types, $primitives, $objects);
        $propertyAdapter = new ConcreteObjectPropertyAdapter($propertyTypeAdapter);
        return new ConcreteObjectAdapter($objectMethodAdapter, $propertyAdapter, $sampleAdapter, $databases);
    }

    private function getObjects(Code $code, array $types, array $primitives) {

        $objects = [];
        $amountObjectsData = count($this->objectsData);
        $amountNewObjects = 0;

        while($amountNewObjects != $amountObjectsData) {
            $objectAdapter = $this->getObjectAdapter($code, $types, $primitives, $objects);
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

            $primitiveFactory = new ConcretePrimitiveFactory();
            $primitives = $primitiveFactory->createAll();

            $code = $this->getCode();
            $types = $this->getTypes($code, $primitives);
            $objects = $this->getObjects($code, $types, $primitives);

            $valueAdapterAdapter = new ConcreteValueAdapterAdapter();
            $controllerHttpRequestCommandActionAdapter = new ConcreteControllerHttpRequestCommandActionAdapter();
            $controllerHttpRequestCommandUrlAdapter = new ConcreteControllerHttpRequestCommandUrlAdapter();
            $controllerHttpRequestCommandAdapter = new ConcreteControllerHttpRequestCommandAdapter($controllerHttpRequestCommandActionAdapter, $controllerHttpRequestCommandUrlAdapter);
            $controllerHttpRequestViewAdapter = new ConcreteControllerHttpRequestViewAdapter();
            $controllerHttpRequestAdapter = new ConcreteControllerHttpRequestAdapter($controllerHttpRequestCommandAdapter, $controllerHttpRequestViewAdapter, $valueAdapterAdapter);
            $controllerViewTemplateAdapter = new ConcreteControllerViewTemplateAdapter();
            $controllerViewAdapter = new ConcreteControllerViewAdapter($controllerViewTemplateAdapter);
            $controllerAdapter = new ConcreteControllerAdapter($controllerViewAdapter, $controllerHttpRequestAdapter);
            $objectAdapter = $this->getObjectAdapter($code, $types, $primitives, $objects);
            return new ConcreteProjectAdapter($objectAdapter, $controllerAdapter);

        } catch (CodeException $exception) {
            throw new ProjectException('There was an exception while converting data to a Code object.', $exception);
        } catch (DatabaseException $exception) {
            throw new ProjectException('There was an exception while converting data to Database objects.', $exception);
        } catch (ConverterException $exception) {
            throw new ProjectException('There was an exception while converting data to Adapter objects.', $exception);
        } catch (TypeException $exception) {
            throw new ProjectException('There was an exception while converting data to Type objects.', $exception);
        }

    }

}
