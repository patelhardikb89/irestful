<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Factories;
use iRESTful\Rodson\Domain\Inputs\Projects\Adapters\Factories\ProjectAdapterFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteProjectAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteObjectAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteObjectPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRelationalDatabaseAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseCredentialsAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRESTAPIAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteTypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteCodeMethodAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteConverterAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteCodeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteCodeLanguageAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Code;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Exceptions\CodeException;
use iRESTful\Rodson\Domain\Inputs\Projects\Databases\Exceptions\DatabaseException;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Exceptions\TypeException;
use iRESTful\Rodson\Domain\Inputs\Projects\Exceptions\ProjectException;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteObjectPropertyTypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteObjectMethodAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteConverterTypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Factories\ConcretePrimitiveFactory;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteObjectSampleAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerHttpRequestAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerHttpRequestCommandAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerHttpRequestCommandActionAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerHttpRequestCommandUrlAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerHttpRequestViewAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteValueAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerViewTemplateAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteControllerViewAdapter;

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
            $controllerHttpRequestAdapterAdapter = new ConcreteControllerHttpRequestAdapterAdapter($controllerHttpRequestCommandAdapter, $controllerHttpRequestViewAdapter, $valueAdapterAdapter);
            $controllerViewTemplateAdapter = new ConcreteControllerViewTemplateAdapter();
            $controllerViewAdapter = new ConcreteControllerViewAdapter($controllerViewTemplateAdapter);
            $controllerAdapter = new ConcreteControllerAdapter($controllerViewAdapter, $controllerHttpRequestAdapterAdapter);
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
