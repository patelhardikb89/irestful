<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\DatabaseType;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Binaries\Binary;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Floats\Float;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Integers\Integer;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Strings\String;
use iRESTful\Rodson\Domain\Inputs\Types\Databases\Exceptions\DatabaseTypeException;

final class ConcreteDatabaseType implements DatabaseType {
    private $hasBoolean;
    private $binary;
    private $float;
    private $integer;
    private $string;
    public function __construct($hasBoolean, Binary $binary = null, Float $float = null, Integer $integer = null, String $string = null) {

        if (!is_bool($hasBoolean)) {
            throw new DatabaseTypeException('The hasBoolean parameter must be boolean.');
        }

        $amount = ($hasBoolean ? 1 : 0) + (empty($binary) ? 0 : 1) + (empty($float) ? 0 : 1) + (empty($integer) ? 0 : 1) + (empty($string) ? 0 : 1);
        if ($amount != 1) {
            throw new DatabaseTypeException('There must be either a boolean, binary, float, integer or string.  '.$amount.' given.');
        }

        $this->hasBoolean = $hasBoolean;
        $this->binary = $binary;
        $this->float = $float;
        $this->integer = $integer;
        $this->string = $string;
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

    public function getData() {
        
        if ($this->hasBoolean()) {
            return [
                'boolean' => true
            ];
        }

        if ($this->hasBinary()) {
            return [
                'binary' => $this->getBinary()->getData()
            ];
        }

        if ($this->hasFloat()) {
            return [
                'float' => $this->getFloat()->getData()
            ];
        }

        if ($this->hasInteger()) {
            return [
                'integer' => $this->getInteger()
            ];
        }

        return [
            'string' =>  $this->getString()->getData()
        ];
    }

}
