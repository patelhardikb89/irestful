<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Fields\Field;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Exceptions\TableException;

final class ConcreteTable implements Table {
    private $name;
    private $engine;
    private $fields;
    private $primaryKey;
    private static $possibleEngines = ['innodb', 'cluster'];
    public function __construct($name, $engine, array $fields) {

        if (empty($fields)) {
            throw new TableException('The fields array cannot be empty.');
        }

        $matches = [];
        preg_match_all('/[a-z\_]+/s', $name, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $name)) {
            throw new TableException('The name must only contain lowercase letters and underscores.');
        }

        $engine = strtolower($engine);
        if (!in_array($engine, self::$possibleEngines)) {
            throw new TableException('The engine must be one of those: '.implode(',', self::$possibleEngines));
        }

        foreach($fields as $oneField) {
            if (!($oneField instanceof Field)) {
                throw new TableException('The fields array must only contain Field objects.  At least one of them is not a Field object.');
            }
        }

        $this->name = $name;
        $this->engine = $engine;
        $this->fields = $fields;
        $this->primaryKey = $this->findPrimaryKey($fields);
    }

    public function hasPrimaryKey() {
        return !empty($this->primaryKey);
    }

    public function getPrimaryKey() {
        return $this->primaryKey;
    }

    public function getName() {
        return $this->name;
    }

    public function getEngine() {
        return $this->engine;
    }

    public function getFields() {
        return $this->fields;
    }

    private function findPrimaryKey(array $fields) {

        foreach($fields as $oneField) {

            if ($oneField->isPrimaryKey()) {
                return $oneField;
            }

        }

        return null;

    }
}
