<?php
namespace iRESTful\Rodson\DSLs\Infrastructure\Factories;
use iRESTful\Rodson\DSLs\Domain\Projects\Adapters\Factories\ProjectAdapterFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteProjectAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteObjectAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteObjectPropertyAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteControllerAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteRelationalDatabaseAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseCredentialsAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteRESTAPIAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteTypeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteConverterAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Codes\Exceptions\CodeException;
use iRESTful\Rodson\DSLs\Domain\Projects\Databases\Exceptions\DatabaseException;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Exceptions\TypeException;
use iRESTful\Rodson\DSLs\Domain\Projects\Exceptions\ProjectException;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteObjectPropertyTypeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteConverterTypeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Factories\ConcretePrimitiveFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteControllerViewTemplateAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteControllerViewAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntityAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntitySampleAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntitySampleNodeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Factories\ConcreteDateTimeFactory;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Infrastructure\Adapters\ConcreteDateTimeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Infrastructure\Factories\V4UuidFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntitySampleReferenceAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteSubDSLAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteUrlAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Factories\ConcreteDSLAdapterFactory;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteParentObjectAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteObjectComboAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteObjectComboPropertyAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteEntityDataAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteCodeLanguageAdapter;

final class ConcreteProjectAdapterFactory implements ProjectAdapterFactory {
    private $codeData;
    private $convertersData;
    private $databasesData;
    private $typesData;
    private $objectsData;
    private $parentsData;
    private $baseDirectory;
    public function __construct(
        array $codeData,
        array $convertersData,
        array $databasesData,
        array $typesData,
        array $objectsData,
        array $parentsData,
        $baseDirectory
    ) {
        $this->codeData = $codeData;
        $this->convertersData = $convertersData;
        $this->databasesData = $databasesData;
        $this->typesData = $typesData;
        $this->objectsData = $objectsData;
        $this->parentsData = $parentsData;
        $this->baseDirectory = $baseDirectory;

    }

    private function getDatabases() {
        $urlAdapter = new ConcreteUrlAdapter();
        $credentialsAdapter = new ConcreteDatabaseCredentialsAdapter();
        $relationalDatabaseAdapter = new ConcreteRelationalDatabaseAdapter($credentialsAdapter);
        $restAPIAdapter = new ConcreteRESTAPIAdapter($urlAdapter, $credentialsAdapter);
        $databaseAdapter = new ConcreteDatabaseAdapter($relationalDatabaseAdapter, $restAPIAdapter);
        return $databaseAdapter->fromDataToDatabases($this->databasesData);
    }

    private function getConverterAdapter(array $types, array $primitives) {
        $converterTypeAdapter = new ConcreteConverterTypeAdapter();
        return new ConcreteConverterAdapter($converterTypeAdapter, $types, $primitives);
    }

    private function getConverters(array $types, array $primitives) {
        $converterAdapter = $this->getConverterAdapter($types, $primitives);
        return $converterAdapter->fromDataToConverters($this->convertersData);
    }

    private function getTypes(array $primitives) {

        $typesData = $this->typesData;

        $getTypeAdapter = function(array $converters) {
            $binaryAdapter = new ConcreteDatabaseTypeBinaryAdapter();
            $floatAdapter = new ConcreteDatabaseTypeFloatAdapter();
            $integerAdapter = new ConcreteDatabaseTypeIntegerAdapter();
            $stringAdapter = new ConcreteDatabaseTypeStringAdapter();
            $databaseTypeAdapter = new ConcreteDatabaseTypeAdapter($binaryAdapter, $floatAdapter, $integerAdapter, $stringAdapter);
            return new ConcreteTypeAdapter($databaseTypeAdapter, $converters);
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

    private function getObjectAdapter(array $types, array $primitives, array $objects, array $databases, array $parents) {

        $parentObjectAdapter = new ConcreteParentObjectAdapter();
        $propertyTypeAdapter = new ConcreteObjectPropertyTypeAdapter($parentObjectAdapter, $types, $primitives, $objects);
        $propertyAdapter = new ConcreteObjectPropertyAdapter($propertyTypeAdapter);
        $comboPropertyAdapter = new ConcreteObjectComboPropertyAdapter();
        $comboAdapter = new ConcreteObjectComboAdapter($comboPropertyAdapter);
        $converters = $this->getConverters($types, $primitives);
        return new ConcreteObjectAdapter($propertyAdapter, $comboAdapter, $databases, $parents, $converters);
    }

    private function getObjects(array $types, array $primitives, array $databases, array $parents) {

        $objects = [];
        $amountObjectsData = count($this->objectsData);
        $amountNewObjects = 0;

        while($amountNewObjects != $amountObjectsData) {
            $objectAdapter = $this->getObjectAdapter($types, $primitives, $objects, $databases, $parents);
            $newObjects = $objectAdapter->fromDataToValidObjects($this->objectsData);
            $amountNewObjects = count($newObjects);
            if ($amountNewObjects == count($objects)) {
                break;
            }

            $objects = $newObjects;
        }

        return $objects;

    }

    private function getEntityAdapter(array $objects) {

        $dateTimeAdapter = new ConcreteDateTimeAdapter('America/Montreal');
        $dateTimeFactory = new ConcreteDateTimeFactory($dateTimeAdapter);
        $uuidFactory = new V4UuidFactory();

        $referenceAdapter = new ConcreteEntitySampleReferenceAdapter();
        $sampleAdapter = new ConcreteEntitySampleAdapter($uuidFactory, $dateTimeFactory, $referenceAdapter, $objects);
        $sampleNodeAdapter = new ConcreteEntitySampleNodeAdapter($sampleAdapter);

        $entityDataAdapter = new ConcreteEntityDataAdapter($uuidFactory, $dateTimeFactory, $objects);
        return new ConcreteEntityAdapter($sampleNodeAdapter, $entityDataAdapter);
    }

    public function create() {

        try {

            $codeLanguageAdapter = new ConcreteCodeLanguageAdapter();
            $codeAdapter = new ConcreteCodeAdapter($codeLanguageAdapter, $this->baseDirectory);
            $code = $codeAdapter->fromDataToCode($this->codeData);

            $dslAdapterFactory = new ConcreteDSLAdapterFactory();
            $dslAdapter = $dslAdapterFactory->create();

            $primitiveFactory = new ConcretePrimitiveFactory();
            $primitives = $primitiveFactory->createAll();

            $types = $this->getTypes($primitives);
            $databases = $this->getDatabases();
            $subDSLAdapterAdapter = new ConcreteSubDSLAdapter($dslAdapter, $databases, $this->baseDirectory);

            $parents = $subDSLAdapterAdapter->fromDataToSubDSLs($this->parentsData);
            $objects = $this->getObjects($types, $primitives, $databases, $parents);

            $controllerViewTemplateAdapter = new ConcreteControllerViewTemplateAdapter();
            $controllerViewAdapter = new ConcreteControllerViewAdapter($controllerViewTemplateAdapter);
            $controllerAdapter = new ConcreteControllerAdapter($controllerViewAdapter);
            $objectAdapter = $this->getObjectAdapter($types, $primitives, $objects, $databases, $parents);
            $entityAdapter = $this->getEntityAdapter($objects);

            return new ConcreteProjectAdapter($code, $objectAdapter, $entityAdapter, $controllerAdapter, $subDSLAdapterAdapter);

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
