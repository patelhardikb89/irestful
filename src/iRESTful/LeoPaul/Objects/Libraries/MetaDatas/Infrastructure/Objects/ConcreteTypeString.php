<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Objects;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Strings\StringType;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Types\Exceptions\TypeException;

final class ConcreteTypeString implements StringType {
    private $specificCharacterSize;
    private $maximumCharacterSize;
    public function __construct($specificCharacterSize = null, $maximumCharacterSize = null) {

        if (!is_null($specificCharacterSize) && !is_null($maximumCharacterSize)) {
            throw new TypeException('The specificCharacterSize and maximumCharacterSize cannot be noth not null.');
        }

        if (!is_null($specificCharacterSize) && !is_int($specificCharacterSize)) {
            throw new TypeException('The specificCharacterSize must be an integer if set.');
        }

        if (!is_null($maximumCharacterSize) && !is_int($maximumCharacterSize)) {
            throw new TypeException('The maximumCharacterSize must be an integer if set.');
        }

        if (!is_null($specificCharacterSize) && ($specificCharacterSize <= 0)) {
            throw new TypeException('The specificCharacterSize must be greater than 0.');
        }

        if (!is_null($maximumCharacterSize) && ($maximumCharacterSize <= 0)) {
            throw new TypeException('The maximumCharacterSize must be greater than 0.');
        }

        $this->specificCharacterSize = $specificCharacterSize;
        $this->maximumCharacterSize = $maximumCharacterSize;
    }

    public function hasSpecificCharacterSize() {
        return !empty($this->specificCharacterSize);
    }

    public function getSpecificCharacterSize() {
        return $this->specificCharacterSize;
    }

    public function hasMaxCharacterSize() {
        return !empty($this->maximumCharacterSize);
    }

    public function getMaxCharacterSize() {
        return $this->maximumCharacterSize;
    }
}
