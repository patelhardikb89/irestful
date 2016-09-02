<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\From;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Exceptions\FromException;

final class ConcreteClassInstructionConversionFrom implements From {
    private $isData;
    private $isInput;
    private $isMultiple;
    private $assignment;
    public function __construct($isData, $isInput, $isMultiple, Assignment $assignment = null) {

        $isData = (bool) $isData;
        $isInput = (bool) $isInput;
        $isMultiple = (bool) $isMultiple;

        if ($isInput && !$isData) {
            throw new FromException('The from is an input, therefore it must be data.');
        }
        
        $amount = ($isInput ? 1 : 0) + (empty($assignment) ? 0 : 1);
        if ($amount != 1) {
            throw new FromException('The from must be either an input or an assignment.  '.$amount.' given.');
        }

        $this->isData = $isData;
        $this->isInput = $isInput;
        $this->isMultiple = $isMultiple;
        $this->assignment = $assignment;

    }

    public function isData() {
        return $this->isData;
    }

    public function isInput() {
        return $this->isInput;
    }

    public function isMultiple() {
        return $this->isMultiple;
    }

    public function isNowMultiple() {
        $this->isMultiple = true;
        return $this;
    }

    public function hasAssignment() {
        return !empty($this->assignment);
    }

    public function getAssignment() {
        return $this->assignment;
    }

    public function getData() {
        return [
            'is_data' => $this->isData(),
            'is_input' => $this->isInput(),
            'is_multiple' => $this->isMultiple(),
            'assignment' => $this->getAssignment()->getData()
        ];
    }

}
