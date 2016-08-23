<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Element;

final class ConcreteClassInstructionConversion implements Conversion {
    private $from;
    private $to;
    public function __construct(Element $from, Element $to) {
        $this->from = $from;
        $this->to = $to;
    }

    public function from() {
        return $this->from;
    }

    public function to() {
        return $this->to;
    }

    public function getData() {
        return [
            'from' => $this->from()->getData(),
            'to' => $this->to()->getData()
        ];
    }

}
