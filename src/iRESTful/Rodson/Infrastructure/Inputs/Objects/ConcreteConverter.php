<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Converter;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Codes\Methods\Method;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Exceptions\ConverterException;

final class ConcreteConverter implements Converter {
    private $from;
    private $to;
    private $method;
    public function __construct(Method $method, Type $from = null, Type $to = null) {

        if (empty($from) && empty($to)) {
            throw new ConverterException('The from and to Type cannot be both empty.');
        }

        $this->from = $from;
        $this->to = $to;
        $this->method = $method;
    }

    public function hasFromType() {
        return !empty($this->from);
    }

    public function fromType() {
        return $this->from;
    }

    public function hasToType() {
        return !empty($this->to);
    }

    public function toType() {
        return $this->to;
    }

    public function getMethod() {
        return $this->method;
    }
}
