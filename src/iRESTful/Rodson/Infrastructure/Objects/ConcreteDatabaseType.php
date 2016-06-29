<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Types\Databases\DatabaseType;
use iRESTful\Rodson\Domain\Types\Databases\Binaries\Binary;
use iRESTful\Rodson\Domain\Types\Databases\Floats\Float;
use iRESTful\Rodson\Domain\Types\Databases\Integers\Integer;
use iRESTful\Rodson\Domain\Types\Databases\Strings\String;
use iRESTful\Rodson\Domain\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseType implements DatabaseType {
    private $name;
    private $hasBoolean;
    private $binary;
    private $float;
    private $integer;
    private $string;
    public function __construct($name, $hasBoolean, Binary $binary = null, Float $float = null, Integer $integer = null, String $string = null) {

        if (!is_bool($hasBoolean)) {
            throw new DatabaseTypeException('The hasBoolean parameter must be boolean.');
        }

        if (empty($name) || !is_string($name)) {
            throw new DatabaseTypeException('The name must be a non-empty string.');
        }

        $amount = ($hasBoolean ? 1 : 0) + (empty($binary) ? 0 : 1) + (empty($float) ? 0 : 1) + (empty($integer) ? 0 : 1) + (empty($string) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseTypeException('There must be either a boolean, binary, float, integer or string.  '.$amount.' given.');
        }

        $this->hasBoolean = $hasBoolean;
        $this->name = $name;
        $this->binary = $binary;
        $this->float = $float;
        $this->integer = $integer;
        $this->string = $string;
    }

    public function getName() {
        return $this->name;
    }

    public function hasBoolean() {
        return $this->hasBoolean;
    }

    public function hasBinary() {
        return !empty($this->binary);
    }

    public function getBinary() {
        return $this->binary;
    }

    public function hasFloat() {
        return !empty($this->float);
    }

    public function getFloat() {
        return $this->float;
    }

    public function hasInteger() {
        return !empty($this->integer);
    }

    public function getInteger() {
        return $this->integer;
    }

    public function hasString() {
        return !empty($this->string);
    }

    public function getString() {
        return $this->string;
    }

}
