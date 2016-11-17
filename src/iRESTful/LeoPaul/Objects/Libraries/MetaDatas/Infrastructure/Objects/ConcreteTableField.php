<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Exceptions\FieldException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\ForeignKeys\ForeignKey;

final class ConcreteTableField implements Field {
    private $name;
    private $type;
    private $isUnique;
    private $isPrimaryKey;
    private $isNullable;
    private $foreignKey;
    private $default;
    private $isRecursive;
    public function __construct($name, Type $type, $isPrimaryKey, $isUnique, $isNullable, $default = null, ForeignKey $foreignKey = null, $isRecursive = false) {

        if (!is_string($name) || empty($name)) {
            throw new FieldException('The name must be a non-empty string.');
        }

        if (!is_null($default) && !is_string($default) && !is_numeric($default)) {
            throw new FieldException('The default value must be a string or a numeric value if not null.');
        }

        if ($isPrimaryKey && !empty($foreignKey)) {
            throw new FieldException('The field ('.$name.') cannot be both a primary key and a foreign key.');
        }

        $isPrimaryKey = (bool) $isPrimaryKey;
        if ($isPrimaryKey) {
            if (!$type->hasBinary() && !$type->hasInteger()) {
                throw new FieldException('The Type of a primary key Field must be either integer or Binary.');
            }

        }

        $matches = [];
        preg_match_all('/[a-z\_]+/s', $name, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $name)) {
            throw new FieldException('The name ('.$name.') must only contain lowercase letters and underscores.');
        }

        if (!is_null($default) && ($default !== 'null')) {

            if ($type->hasFloat() && !is_float($default)) {
                throw new FieldException('The default value ('.$default.') must be a float if not null, since the Type is a float.');
            }

            if ($type->hasInteger() && !is_int($default)) {
                throw new FieldException('The default value ('.$default.') must be an integer if not null, since the Type is an integer.');
            }

            if ($type->hasString() && !is_string($default)) {
                throw new FieldException('The default value ('.$default.') must be a string if not null, since the Type is a string.');
            }
        }

        if (is_string($default) && ($default === 'null') && !$isNullable) {
            throw new FieldException('The default value cannot be null because the Field is not nullable.');
        }

        $this->name = $name;
        $this->type = $type;
        $this->isPrimaryKey = $isPrimaryKey;
        $this->isUnique = ($isPrimaryKey) ? true : (bool) $isUnique;
        $this->isNullable = (bool) $isNullable;
        $this->default = $default;
        $this->foreignKey = $foreignKey;
        $this->isRecursive = (bool) $isRecursive;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function isPrimaryKey() {
        return $this->isPrimaryKey;
    }

    public function isUnique() {
        return $this->isUnique;
    }

    public function isNullable() {
        return $this->isNullable;
    }

    public function hasDefault() {
        return !empty($this->default);
    }

    public function getDefault() {
        return $this->default;
    }

    public function hasForeignKey() {
        return !empty($this->foreignKey);
    }

    public function getForeignKey() {
        return $this->foreignKey;
    }

    public function isRecursive() {
        return $this->isRecursive;
    }

}
