<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Types\Databases\DatabaseType;
use iRESTful\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Type;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseType implements DatabaseType {
    private $name;
    private $type;
    public function __construct($name, Type $type) {

        if (empty($name) || !is_string($name)) {
            throw new DatabaseTypeException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->type = $type;

    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

}
