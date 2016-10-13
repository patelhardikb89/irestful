<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Values\Value;
use iRESTful\DSLs\Domain\Projects\Values\Exceptions\ValueException;

final class ConcreteValue implements Value {
    private $inputVariable;
    private $environmentVariable;
    private $direct;
    public function __construct(string $inputVariable = null, string $environmentVariable = null, string $direct = null) {

        if ($inputVariable == '') {
            $inputVariable = null;
        }

        if ($environmentVariable == '') {
            $environmentVariable = null;
        }

        if ($direct == '') {
            $direct = null;
        }

        $amount = (is_null($inputVariable) ? 0 : 1) + (is_null($environmentVariable) ? 0 : 1) + (is_null($direct) ? 0 : 1);
        if ($amount != 1) {
            throw new ValueException('There must be either an inputVariable, an environmentVariable or a direct value.  '.$amount.' given.');
        }

        $this->inputVariable = $inputVariable;
        $this->environmentVariable = $environmentVariable;
        $this->direct = $direct;
    }

    public function hasInputVariable(): bool {
        return !empty($this->inputVariable);
    }

    public function getInputVariable() {
        return $this->inputVariable;
    }

    public function hasEnvironmentVariable(): bool {
        return !empty($this->environmentVariable);
    }

    public function getEnvironmentVariable() {
        return $this->environmentVariable;
    }

    public function hasDirect(): bool {
        return !empty($this->direct);
    }

    public function getDirect() {
        return $this->direct;
    }

}
