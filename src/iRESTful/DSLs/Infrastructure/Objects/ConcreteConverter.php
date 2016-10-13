<?php
declare(strict_types=1);
namespace iRESTful\DSLs\Infrastructure\Objects;
use iRESTful\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\DSLs\Domain\Projects\Converters\Types\Type;
use iRESTful\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;

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

    public function hasFromType(): bool {
        return !empty($this->from);
    }

    public function fromType() {
        return $this->from;
    }

    public function hasToType(): bool {
        return !empty($this->to);
    }

    public function toType() {
        return $this->to;
    }
}
