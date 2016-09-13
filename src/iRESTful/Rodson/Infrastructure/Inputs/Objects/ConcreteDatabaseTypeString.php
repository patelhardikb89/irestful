<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\String;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Databases\Strings\Exceptions\StringException;

final class ConcreteDatabaseTypeString implements String {
    private $specificCharacterSize;
    private $maximumCharacterSize;
    public function __construct($specificCharacterSize = null, $maximumCharacterSize = null) {

        if (!is_null($specificCharacterSize) && !is_null($maximumCharacterSize)) {
            throw new StringException('The specificCharacterSize and maximumCharacterSize cannot be noth not null.');
        }

        if (!is_null($specificCharacterSize) && !is_int($specificCharacterSize)) {
            throw new StringException('The specificCharacterSize must be an integer if set.');
        }

        if (!is_null($maximumCharacterSize) && !is_int($maximumCharacterSize)) {
            throw new StringException('The maximumCharacterSize must be an integer if set.');
        }

        if (!is_null($specificCharacterSize) && ($specificCharacterSize <= 0)) {
            throw new StringException('The specificCharacterSize must be greater than 0.');
        }

        if (!is_null($maximumCharacterSize) && ($maximumCharacterSize <= 0)) {
            throw new StringException('The maximumCharacterSize must be greater than 0.');
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

    public function getData() {
        $output = [];
        if ($this->hasSpecificCharacterSize()) {
            $output['specific'] = $this->getSpecificCharacterSize();
        }

        if ($this->hasMaxCharacterSize()) {
            $output['max'] = $this->getMaxCharacterSize();
        }

        return $output;
    }
}
