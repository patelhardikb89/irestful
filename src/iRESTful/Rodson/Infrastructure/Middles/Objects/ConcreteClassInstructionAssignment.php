<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Exeptions\AssignmentException;

final class ConcreteClassInstructionAssignment implements Assignment {
    private $isReturned;
    private $variableName;
    private $database;
    private $conversion;
    public function __construct($isReturned, $variableName = null, Database $database = null, Conversion $conversion = null) {

        if (empty($variableName)) {
            $variableName = null;
        }

        if (!empty($variableName) && !is_string($variableName)) {
            throw new AssignmentException('The variableName must be a string if non-empty.');
        }

        $isReturned = (bool) $isReturned;
        $amount = ($isReturned ? 1 : 0) + (empty($variableName) ? 0 : 1);
        if ($amount != 1) {
            throw new AssignmentException('At least one of these must be true/non-empty: isReturned, variableName.  '.$amount.' given.');
        }

        $amount = (empty($database) ? 0 : 1) + (empty($conversion) ? 0 : 1);
        if ($amount != 1) {
            throw new AssignmentException('At least one of these must be non-empty: database, conversion.  '.$amount.' given.')
        }

        $this->isReturned = $isReturned;
        $this->variableName = $variableName;
        $this->database = $database;
        $this->conversion = $conversion;
    }

    public function isReturned() {
        return $this->isReturned;
    }

    public function hasVariableName() {
        return !empty($this->variableName);
    }

    public function getVariableName() {
        return $this->variableName;
    }

    public function hasDatabase() {
        return !empty($this->database);
    }

    public function getDatabase() {
        return $this->database;
    }

    public function hasConversion() {
        return !empty($this->conversion);
    }

    public function getConversion() {
        return $this->conversion;
    }

}
