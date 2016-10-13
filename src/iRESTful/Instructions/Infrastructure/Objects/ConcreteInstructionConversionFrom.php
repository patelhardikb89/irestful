<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Conversions\From\From;
use iRESTful\Instructions\Domain\Assignments\Assignment;
use iRESTful\Instructions\Domain\Conversions\From\Exceptions\FromException;

final class ConcreteInstructionConversionFrom implements From {
    private $isInput;
    private $inputKeynames;
    private $assignment;
    public function __construct($isInput, array $inputKeynames, Assignment $assignment = null) {

        $isInput = (bool) $isInput;
        $amount = ($isInput ? 1 : 0) + (empty($assignment) ? 0 : 1);
        if ($amount != 1) {
            throw new FromException('The from must be either an input or an assignment.  '.$amount.' given.');
        }

        $this->isInput = $isInput;
        $this->inputKeynames = $inputKeynames;
        $this->assignment = $assignment;

    }

    public function isData() {

        if ($this->isInput() || !$this->hasAssignment()) {
            return true;
        }

        $assignment = $this->getAssignment();
        if ($assignment->hasDatabase()) {
            return $assignment->getDatabase()->getRetrieval()->hasHttpRequest();
        }

        if ($assignment->hasMergedAssignments()) {
            return true;
        }

        return $assignment->getConversion()->to()->isData();
    }

    public function isInput() {
        return $this->isInput;
    }

    public function hasInputKeynames() {
        return !empty($this->inputKeynames);
    }

    public function getInputKeynames() {
        return $this->inputKeynames;
    }

    public function hasAssignment() {
        return !empty($this->assignment);
    }

    public function getAssignment() {
        return $this->assignment;
    }

}
