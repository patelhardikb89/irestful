<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Adapters\Adapter;
use iRESTful\Rodson\Domain\Types\Type;
use iRESTful\Rodson\Domain\Codes\Methods\Method;

final class ConcreteAdapter implements Adapter {
    private $from;
    private $to;
    private $method;
    public function __construct(Type $from, Type $to, Method $method) {
        $this->from = $from;
        $this->to = $to;
        $this->method = $method;
    }

    public function fromType() {
        return $this->from;
    }

    public function toType() {
        return $this->to;
    }

    public function getMethod() {
        return $this->method;
    }

}
