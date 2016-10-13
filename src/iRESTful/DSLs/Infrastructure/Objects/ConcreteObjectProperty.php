<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Property;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Types\Type;
use iRESTful\DSLs\Domain\Projects\Objects\Properties\Exceptions\PropertyException;

final class ConcreteObjectProperty implements Property {
    private $name;
    private $type;
    private $isOptional;
    private $isUnique;
    private $isKey;
    private $default;
    public function __construct(string $name, Type $type, bool $isOptional, bool $isUnique, bool $isKey, string $default = null) {

        if (empty($name)) {
            throw new PropertyException('The name must be a non-empty string.');
        }

        $matches = [];
        preg_match_all('/[a-z\_]+/s', $name, $matches);
        if (!isset($matches[0][0]) || ($matches[0][0] != $name)) {
            throw new PropertyException('The name ('.$name.') must only contain lowercase letters (a-z) and underscores (_).');
        }

        $this->name = $name;
        $this->type = $type;
        $this->isOptional = $isOptional;
        $this->isUnique = $isUnique;
        $this->isKey = $isKey;
        $this->default = $default;

    }

    public function getName(): string {
        return $this->name;
    }

    public function getType(): Type {
        return $this->type;
    }

    public function isOptional(): bool {
        return $this->isOptional;
    }

    public function isUnique(): bool {
        return $this->isUnique;
    }

    public function isKey(): bool {
        return $this->isKey;
    }

    public function hasDefault(): bool {
        return !is_null($this->default);
    }

    public function getDefault() {
        return $this->default;
    }

}
