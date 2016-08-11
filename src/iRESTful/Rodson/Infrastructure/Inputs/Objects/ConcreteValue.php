<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Values\Value;

final class ConcreteValue implements Value {
    private $inputVariable;
    private $environmentVariable;
    private $direct;
    public function __construct($inputVariable = null, $environmentVariable = null, $direct = null) {

        if (empty($inputVariable)) {
            $inputVariable = null;
        }

        if (empty($environmentVariable)) {
            $environmentVariable = null;
        }

        if (empty($direct)) {
            $direct = null;
        }

        $this->inputVariable = $inputVariable;
        $this->environmentVariable = $environmentVariable;
        $this->direct = $direct;
    }

    public function hasInputVariable() {
        return !empty($this->inputVariable);
    }

    public function getInputVariable() {
        return $this->inputVariable;
    }

    public function hasEnvironmentVariable() {
        return !empty($this->environmentVariable);
    }

    public function getEnvironmentVariable() {
        return $this->environmentVariable;
    }

    public function hasDirect() {
        return !empty($this->direct);
    }

    public function getDirect() {
        return $this->direct;
    }

}
