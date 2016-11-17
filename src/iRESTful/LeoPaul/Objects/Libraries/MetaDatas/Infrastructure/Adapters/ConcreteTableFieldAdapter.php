<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Adapters\FieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects\ConcreteTableField;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Adapters\ForeignKeyAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\Exceptions\ForeignKeyException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\ConstructorMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\ClassMetaData;

final class ConcreteTableFieldAdapter implements FieldAdapter {
    private $fieldDelimiter;
    private $foreignKeyAdapter;
    public function __construct($fieldDelimiter, ForeignKeyAdapter $foreignKeyAdapter = null) {
        $this->fieldDelimiter = $fieldDelimiter;
        $this->foreignKeyAdapter = $foreignKeyAdapter;
    }

    public function fromDataToFields(array $data) {
        return $this->fromDataToFieldsInternally($data);
    }

    public function fromRelationDataToFields(array $data) {

        if (!isset($data['master'])) {
            throw new FieldException('The master keyname is mandatory in order to convert data to Field objects.');
        }

        if (!isset($data['slave'])) {
            throw new FieldException('The slave keyname is mandatory in order to convert data to Field objects.');
        }

        $master = $this->createRelationField($data['master']['container'], $data['master']['argument'], 'master_uuid');
        $slave = $this->createRelationField($data['slave']['container'], $data['slave']['argument'], 'slave_uuid');

        return [$master, $slave];
    }

    private function createRelationField($containerName, ConstructorMetaData $constructorMetaData, $keyname) {
        $isPrimaryKey = false;
        $isUnique = false;
        $isNullable = false;

        $argumentMetaData = $constructorMetaData->getArgumentMetaData();
        $type = $constructorMetaData->getType();


        $default = null;
        if ($constructorMetaData->hasDefault()) {
            $default = $constructorMetaData->getDefault();
        }

        if (empty($this->foreignKeyAdapter)) {
            throw new FieldException('The foreignKeyAdapter is necessary in order to create a relation Field object.');
        }

        $foreignKey = $this->foreignKeyAdapter->fromContainerNameToForeignKey($containerName);
        return new ConcreteTableField($keyname, $type, $isPrimaryKey, $isUnique, $isNullable, $default, $foreignKey);
    }

    private function fromDataToFieldsInternally(array $data, $keynamePrefix = null) {
        $output = [];
        foreach($data as $oneData) {
            $fields = $this->fromOneDataToFieldsInternally($oneData, $keynamePrefix);
            if (!empty($fields)) {
                $output = array_merge($output, $fields);
            }
        }

        return $output;
    }

    private function fromClassMetaDataToFieldsInternally(ClassMetaData $classMetaData, $keyname, $keynamePrefix) {
        if (!$classMetaData->hasContainerName()) {
            $arguments = $classMetaData->getArguments();

            $output = [];
            foreach($arguments as $oneArgument) {
                $oneFields = $this->fromConstructorMetaDataToFieldsInternally($oneArgument, null, $keynamePrefix);
                if (!empty($oneFields)) {
                    $output = array_merge($output, $oneFields);
                }
            }

            return $output;
        }

        $output = [];
        $arguments = $classMetaData->getArguments();
        foreach($arguments as $oneArgument) {
            $oneFields = $this->fromConstructorMetaDataToFieldsInternally($oneArgument, $classMetaData, $keyname);
            if (!empty($oneFields)) {
                $output = array_merge($output, $oneFields);
            }
        }

        return $output;
    }

    private function fromConstructorMetaDataToFieldsInternally(ConstructorMetaData $constructorMetaData, ClassMetaData $parentClassMetaData = null, $keynamePrefix = null) {

        $getKeyArgument = function(array $arguments) {
            foreach($arguments as $oneArgument) {
                if ($oneArgument->isKey()) {
                    return $oneArgument;
                }
            }

            return null;
        };

        $keyname = $constructorMetaData->getKeyname();
        if (!empty($keynamePrefix)) {
            $keyname = $keynamePrefix.$this->fieldDelimiter.$keyname;
        }

        if (!$constructorMetaData->hasType()) {
            $argumentMetaData = $constructorMetaData->getArgumentMetaData();
            if (!$argumentMetaData->hasClassMetaData()) {

                if ($argumentMetaData->hasArrayMetaData()) {
                    return null;
                }

                if ($argumentMetaData->isRecursive()) {

                    $recursiveArguments = $parentClassMetaData->getArguments();
                    $recursiveKeyArgument = $getKeyArgument($recursiveArguments);


                    $argumentMetaData = $constructorMetaData->getArgumentMetaData();
                    $isPrimaryKey = $constructorMetaData->isKey();
                    $isUnique = $constructorMetaData->isUnique();
                    $type = $recursiveKeyArgument->getType();
                    $isNullable = $argumentMetaData->isOptional();

                    $default = null;
                    if ($constructorMetaData->hasDefault()) {
                        $default = $constructorMetaData->getDefault();
                    }

                    return [
                        new ConcreteTableField($keyname, $type, $isPrimaryKey, $isUnique, $isNullable, $default, null, true)
                    ];
                }

                throw new FieldException('The given ConstructorMetaData object contains an ArgumentMetaData that does not have a type or a ClassMetaData.');
            }

            $classMetaData = $argumentMetaData->getClassMetaData();
            $keynamePrefix = $constructorMetaData->getKeyname();
            return $this->fromClassMetaDataToFieldsInternally($classMetaData, $keyname, $keynamePrefix);
        }

        $argumentMetaData = $constructorMetaData->getArgumentMetaData();
        $isPrimaryKey = $constructorMetaData->isKey();
        $isUnique = $constructorMetaData->isUnique();
        $type = $constructorMetaData->getType();
        $isNullable = $argumentMetaData->isOptional();

        $default = null;
        if ($constructorMetaData->hasDefault()) {
            $default = $constructorMetaData->getDefault();
        }

        try {

            $foreignKey = null;
            if (!empty($this->foreignKeyAdapter) && !empty($parentClassMetaData)) {
                $foreignKey = $this->foreignKeyAdapter->fromDataToForeignKey([
                    'parent_class_metadata' => $parentClassMetaData,
                    'argument_metadata' => $argumentMetaData
                ]);
            }

            return [
                new ConcreteTableField($keyname, $type, $isPrimaryKey, $isUnique, $isNullable, $default, $foreignKey)
            ];

        } catch (ForeignKeyException $exception) {
            throw new FieldException('There was an exception while converting data to a ForeignKey object.', $exception);
        }
    }

    private function fromOneDataToFieldsInternally(array $data, $keynamePrefix = null) {

        if (!isset($data['parent_class_metadata'])) {
            throw new FieldException('The parent_class_metadata keyname is mandatory in order to convert data to a Field object.');
        }

        if (!isset($data['constructor_metadata'])) {
            throw new FieldException('The constructor_metadata keyname is mandatory in order to convert data to a Field object.');
        }

        return $this->fromConstructorMetaDataToFieldsInternally(
            $data['constructor_metadata'],
            $data['parent_class_metadata'],
            $keynamePrefix
        );

    }

}
