<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Domain\Tables\Fields\Types\Adapters\TypeAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;

final class PDOTableFieldTypeAdapter implements TypeAdapter {

    public function __construct() {

    }

    public function fromTypeToTypeInSqlQueryLine(Type $type) {

        if ($type->hasBinary()) {
            $binary = $type->getBinary();
            if ($binary->hasSpecificBitSize()) {
                $bitSize = $binary->getSpecificBitSize();
                $byte = ceil($bitSize / 8);
                return 'binary ('.$byte.')';
            }

            if ($binary->hasMaxBitSize()) {
                $maxBitSize = $binary->getMaxBitSize();
                $byte = ceil($maxBitSize / 8);
                return 'varbinary ('.$byte.')';
            }

            return 'blob';
        }

        if ($type->hasFloat()) {
            $float = $type->getFloat();
            $digitsAmount = $float->getDigitsAmount();
            $precision = $float->getPrecision();
            return 'decimal ('.$digitsAmount.', '.$precision.')';
        }

        if ($type->hasInteger()) {
            $integer = $type->getInteger();
            $maxBitSize = $integer->getMaximumBitSize();
            $byte = ceil($maxBitSize / 8);

            if ($byte == 1) {
                return 'tinyint';
            }

            if ($byte == 2) {
                return 'smallint';
            }

            if ($byte == 3) {
                return 'mediumint';
            }

            if ($byte == 4) {
                return 'int';
            }

            return 'bigint';
        }

        if ($type->isBoolean()) {
            return 'bool';
        }

        $string = $type->getString();
        if ($string->hasSpecificCharacterSize()) {
            $charSize = $string->getSpecificCharacterSize();
            return 'char ('.$charSize.')';
        }

        if ($string->hasMaxCharacterSize()) {
            $maxCharSize = $string->getMaxCharacterSize();
            return 'varchar ('.$maxCharSize.')';
        }

        return 'text';

    }

}
