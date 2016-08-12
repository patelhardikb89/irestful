<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Element;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Exceptions\ElementException;

final class ConcreteClassInstructionConversionElement implements Element {
    private $isData;
    private $class;
    private $assignment;
    public function __construct($isData, ObjectClass $class = null, Assignment $assignment = null) {

        $isData = (bool) $isData;
        $amount = ($isData ? 1 : 0) + (empty($class) ? 0 : 1) + (empty($assignment) ? 0 : 1);
        if ($amount != 1) {
            throw new ElementException('One of these must be true/non-empty: isData, class, assignment.  '.$amount.' given.');
        }

        $this->isData = $isData;
        $this->class = $class;
        $this->assignment = $assignment;

    }

    public function isData() {
        return $this->isData;
    }

    public function hasClass() {
        return !empty($this->class);
    }

    public function getClass() {
        return $this->class;
    }

    public function hasAssignment() {
        return !empty($this->assignment);
    }

    public function getAssignment() {
        return $this->assignment;
    }

}
