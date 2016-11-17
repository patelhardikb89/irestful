<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Adapters\TableAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Adapters\FieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTable;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Exceptions\ClassMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;

final class ConcreteTableAdapter implements TableAdapter {
    private $repository;
    private $fieldAdapter;
    private $engine;
    private $delimiter;
    public function __construct(ClassMetaDataRepository $repository, FieldAdapter $fieldAdapter, $engine, $delimiter) {
        $this->repository = $repository;
        $this->fieldAdapter = $fieldAdapter;
        $this->engine = $engine;
        $this->delimiter = $delimiter;
    }

    public function fromClassMetaDataToTable(ClassMetaData $classMetaData) {
        return $this->fromClassMetaDataToTableInternally($classMetaData);
    }

    public function fromDataToTable(array $data) {

        try {

            $metaData = $this->repository->retrieve($data);
            return $this->fromClassMetaDataToTableInternally($metaData);

        } catch (ClassMetaDataException $exception) {
            throw new TableException('There was an exception while retrieving the ClassMetaData object from a container.', $exception);
        }
    }

    public function fromDataToTables(array $containerNames) {

        $output = [];
        foreach($containerNames as $oneContainerName) {
            $metaData = $this->repository->retrieve([
                'container' => $oneContainerName
            ]);

            $tables = $this->fromClassMetaDataToTablesInternally($metaData);
            if (!empty($tables)) {
                $output = array_merge($output, $tables);
            }
        }

        return $output;

    }

    private function findRelationTables(ClassMetaData $classMetaData) {

        $getKeyArgument = function(array $arguments) {

            foreach($arguments as $oneArgument) {
                if ($oneArgument->isKey()) {
                    return $oneArgument;
                }
            }

            return null;
        };

        if (!$classMetaData->hasContainerName()) {
            return [];
        }

        $output = [];
        $containerName = $classMetaData->getContainerName();
        $arguments = $classMetaData->getArguments();
        foreach($arguments as $oneArgument) {
            $argumentMetaData = $oneArgument->getArgumentMetaData();
            if ($argumentMetaData->hasArrayMetaData()) {
                $arrayMetaData = $argumentMetaData->getArrayMetaData();
                if ($arrayMetaData->hasElementsType()) {
                    $elementsType = $arrayMetaData->getElementsType();
                    $elementsMetaData = $this->repository->retrieve([
                        'class' => $elementsType
                    ]);

                    $toContainer = $elementsMetaData->getContainerName();
                    $elementsArguments = $elementsMetaData->getArguments();
                    $fields = $this->fieldAdapter->fromRelationDataToFields([
                        'master' => [
                            'container' => $containerName,
                            'argument' => $getKeyArgument($arguments)
                        ],
                        'slave' => [
                            'container' => $toContainer,
                            'argument' => $getKeyArgument($elementsArguments)
                        ]
                    ]);

                    $argumentName = $oneArgument->getKeyname();
                    $tableName = $containerName.$this->delimiter.$argumentName;
                    $output[] = new ConcreteTable($tableName, $this->engine, $fields);
                }
            }
        }

        return $output;
    }

    private function fromClassMetaDataToTablesInternally(ClassMetaData $classMetaData) {
        $table = $this->fromClassMetaDataToTableInternally($classMetaData);
        $relations = $this->findRelationTables($classMetaData);
        return array_merge([$table], $relations);
    }

    private function fromClassMetaDataToTableInternally(ClassMetaData $classMetaData) {
        $getFieldsData = function(array $arguments, ClassMetaData $classMetaData) {
            $output = [];
            foreach($arguments as $oneArgument) {
                $output[] = [
                    'parent_class_metadata' => $classMetaData,
                    'constructor_metadata' => $oneArgument
                ];
            }

            return $output;
        };

        try {

            if (!$classMetaData->hasContainerName()) {
                throw new TableException('The retrieved ClassMetaData object does not have a container.');
            }

            $containerName = $classMetaData->getContainerName();
            $arguments = $classMetaData->getArguments();

            $fields = $this->fieldAdapter->fromDataToFields($getFieldsData($arguments, $classMetaData));
            return new ConcreteTable($containerName, $this->engine, $fields);

        } catch (FieldException $exception) {
            throw new TableException('There was an exception while converting ConstructorMetaData objects to Field objects.', $exception);
        }
    }

}
