<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Methods\Method;

final class ConcreteConverter implements Converter {
    private $keyname;
    private $from;
    private $to;
    private $method;
    public function __construct(string $keyname, Type $from = null, Type $to = null, Method $method = null) {

        if (empty($from) && empty($to)) {
            throw new ConverterException('The from and to Type cannot be both empty.');
        }

        $this->keyname = $keyname;
        $this->from = $from;
        $this->to = $to;
        $this->method = $method;
    }

    public function getKeyname() {
        return $this->keyname;
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

    public function hasMethod() {
        return !empty($this->method);
    }

    public function getMethod() {
        return $this->method;
    }
}
