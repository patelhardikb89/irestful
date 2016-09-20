<?php
namespace iRESTful\Rodson\Infrastructure\Inputs\Objects;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Converter;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Types\Type;
use iRESTful\Rodson\Domain\Inputs\Projects\Converters\Exceptions\ConverterException;

final class ConcreteConverter implements Converter {
    private $from;
    private $to;
    public function __construct(Type $from = null, Type $to = null) {

        if (empty($from) && empty($to)) {
            throw new ConverterException('The from and to Type cannot be both empty.');
        }

        $this->from = $from;
        $this->to = $to;
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
}
