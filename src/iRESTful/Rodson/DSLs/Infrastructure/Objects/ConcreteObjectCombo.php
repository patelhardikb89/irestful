<?php
declare(strict_types=1);
namespace iRESTful\Rodson\DSLs\Infrastructure\Objects;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Combo;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Combos\Properties\Property;

final class ConcreteObjectCombo implements Combo {
    private $from;
    private $to;
    public function __construct(Property $from, Property $to) {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom() {
        return $this->from;
    }

    public function getTo() {
        return $this->to;
    }

}
