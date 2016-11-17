<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Adapters\FieldAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Types\Adapters\TypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class PDOTableFieldAdapter implements FieldAdapter {
    private $typeAdapter;
    private $tableDelimiter;
    public function __construct(TypeAdapter $typeAdapter, $tableDelimiter) {
        $this->typeAdapter = $typeAdapter;
        $this->tableDelimiter = $tableDelimiter;
    }

    public function fromFieldToSQLQueryLine(Field $field) {

        try {

            $name = $field->getName();
            $type = $field->getType();
            $isNullable = $field->isNullable();
            $hasDefault = $field->hasDefault();
            $isPrimaryKey = $field->isPrimaryKey();

            $typeInSqlQueryLine = $this->typeAdapter->fromTypeToTypeInSqlQueryLine($type);
            $query = $name.' '.$typeInSqlQueryLine;
            if (!$isNullable) {
                $query .= ' not null';
            }


            if ($hasDefault) {
                $default = $field->getDefault();
                if ($default != 'null') {
                    $default = "'".$default."'";
                }

                if (($default == 'null') && (!$isNullable)) {
                    throw new FieldException('The default value cannot be null because the field is not nullable.');
                }

                $query .= " default ".$default;
            }

            if ($isPrimaryKey) {

                if ($hasDefault) {
                    throw new FieldException('The field cannot be a primary key and contain a default value.');
                }

                if ($isNullable) {
                    throw new FieldException('The field cannot be a primary key and be nullable.');
                }

                $query = $name.' '.$typeInSqlQueryLine.' primary key';
            }

            return $query;

        } catch (TypeException $exception) {
            throw new FieldException('There was an exception while converting a Type to a type in sql query line.', $exception);
        }
    }

    public function fromFieldsToSQLQueryLines(array $fields) {
        $lines = [];
        foreach($fields as $oneField) {
            $lines[] = $this->fromFieldToSQLQueryLine($oneField);
        }

        return $lines;
    }

}
