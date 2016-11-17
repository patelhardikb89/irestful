<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Schema;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Exceptions\SchemaException;

final class ConcreteSchema implements Schema {
    private $name;
    private $tables;
    public function __construct($name, array $tables = null) {

        if (empty($tables)) {
            $tables = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new SchemaException('The name must be a non-empty string.');
        }

        $matches = [];
        preg_match_all('/[a-z0-9\_]+/s', $name, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $name)) {
            throw new SchemaException('The name ('.$name.') must only contain lowercase letters, numbers and underscores (_).');
        }

        if (!empty($tables)) {
            foreach($tables as $oneTable) {
                if (!($oneTable instanceof \iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Databases\Schemas\Tables\Table)) {
                    throw new SchemaException('The table array must only contain Table objects.');
                }
            }
        }

        $this->name = $name;
        $this->tables = $tables;
    }

    public function getName() {
        return $this->name;
    }

    public function hasTables() {
        return !empty($this->tables);
    }

    public function getTables() {
        return $this->tables;
    }

}
