<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\StringType;
use iRESTful\DSLs\Domain\Projects\Types\Databases\Strings\Exceptions\StringException;

final class ConcreteDatabaseTypeString implements StringType {
    private $specificCharacterSize;
    private $maximumCharacterSize;
    public function __construct(int $specificCharacterSize = null, int $maximumCharacterSize = null) {

        if (!is_null($specificCharacterSize) && !is_null($maximumCharacterSize)) {
            throw new StringException('The specificCharacterSize and maximumCharacterSize cannot be noth not null.');
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

    public function hasSpecificCharacterSize(): bool {
        return !empty($this->specificCharacterSize);
    }

    public function getSpecificCharacterSize() {
        return $this->specificCharacterSize;
    }

    public function hasMaxCharacterSize(): bool {
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
