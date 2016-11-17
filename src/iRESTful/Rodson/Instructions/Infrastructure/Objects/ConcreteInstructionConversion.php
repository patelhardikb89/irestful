<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Objects;
use iRESTful\Rodson\Instructions\Domain\Conversions\Conversion;
use iRESTful\Rodson\Instructions\Domain\Conversions\From\From;
use iRESTful\Rodson\Instructions\Domain\Conversions\To\To;

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
