<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Conversions\Conversion;
use iRESTful\Instructions\Domain\Conversions\From\From;
use iRESTful\Instructions\Domain\Conversions\To\To;

final class ConcreteInstructionConversion implements Conversion {
    private $from;
    private $to;
    public function __construct(From $from, To $to) {
        $this->from = $from;
        $this->to = $to;
    }

    public function from() {
        return $this->from;
    }

    public function to() {
        return $this->to;
    }

}
