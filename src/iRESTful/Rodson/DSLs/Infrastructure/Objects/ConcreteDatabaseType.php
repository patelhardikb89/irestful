<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\DatabaseType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Binaries\BinaryType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Floats\FloatType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Integers\IntegerType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Strings\StringType;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseType implements DatabaseType {
    private $hasBoolean;
    private $binary;
    private $float;
    private $integer;
    private $string;
    private $name;
    private $value;
    public function __construct(bool $hasBoolean, BinaryType $binary = null, FloatType $float = null, IntegerType $integer = null, StringType $string = null) {

        $amount = ($hasBoolean ? 1 : 0) + (empty($binary) ? 0 : 1) + (empty($float) ? 0 : 1) + (empty($integer) ? 0 : 1) + (empty($string) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseTypeException('There must be either a boolean, binary, float, integer or string.  '.$amount.' given.');
        }
        
        $this->hasBoolean = $hasBoolean;
        $this->binary = $binary;
        $this->float = $float;
        $this->integer = $integer;
        $this->string = $string;

        $data = $this->getData();
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->value = (isset($data['value'])) ? $data['value'] : null;
    }

    public function hasBoolean(): bool {
        return $this->hasBoolean;
    }

    public function hasBinary(): bool {
        return !empty($this->binary);
    }

    public function getBinary() {
        return $this->binary;
    }

    public function hasFloat(): bool {
        return !empty($this->float);
    }

    public function getFloat() {
        return $this->float;
    }

    public function hasInteger(): bool {
        return !empty($this->integer);
    }

    public function getInteger() {
        return $this->integer;
    }

    public function hasString(): bool {
        return !empty($this->string);
    }

    public function getString() {
        return $this->string;
    }

    private function getData() {

        if ($this->hasBoolean()) {
            return [
                'name' => 'boolean'
            ];
        }

        if ($this->hasBinary()) {
            return [
                'name' => 'binary',
                'value' => $this->getBinary()->getData()
            ];
        }

        if ($this->hasFloat()) {
            return [
                'name' => 'float',
                'value' => $this->getFloat()->getData()
            ];
        }

        if ($this->hasInteger()) {
            return [
                'name' => 'integer',
                'value' => $this->getInteger()->getData()
            ];
        }

        return [
            'name' => 'string',
            'value' => $this->getString()->getData()
        ];
    }

}
