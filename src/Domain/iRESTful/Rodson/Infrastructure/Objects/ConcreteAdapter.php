<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Adapters\Adapter;
use iRESTful\Rodson\Domain\Types\Type;
use iRESTful\Rodson\Domain\Codes\Code;

final class ConcreteAdapter implements Adapter {
    private $from;
    priavte $to;
    private $code;
    public function __construct(Type $type $from, Type $to, Code $code) {
        $this->from = $from;
        $this->to = $to;
        $this->code = $code;
    }

    public function getFromType() {
        return $this->from;
    }

    public function getToType() {
        return $this->to;
    }

    public function getCode() {
        return $this->code;
    }

}
