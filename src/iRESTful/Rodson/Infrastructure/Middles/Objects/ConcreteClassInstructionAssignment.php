<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Exeptions\AssignmentException;

final class ConcreteClassInstructionAssignment implements Assignment {
    private $variableName;
    private $database;
    private $conversion;
    private $mergedAssignments;
    public function __construct($variableName, Database $database = null, Conversion $conversion = null, array $mergedAssignments = null) {

        if (empty($mergedAssignments)) {
            $mergedAssignments = null;
        }

        if (empty($variableName) || !is_string($variableName)) {
            throw new AssignmentException('The variableName must be a non-empty string.');
        }

        $amount = (empty($mergedAssignments) ? 0 : 1) + (empty($database) ? 0 : 1) + (empty($conversion) ? 0 : 1);
        if ($amount != 1) {
            throw new AssignmentException('At least one of these must be non-empty: mergedAssignments, database, conversion.  '.$amount.' given.');
        }

        if (!empty($mergedAssignments)) {
            foreach($mergedAssignments as $oneMergedAssignment) {
                if (!($oneMergedAssignment instanceof Assignment)) {
                    throw new AssignmentException('The mergedAssignments array must only contain Assignment objects.');
                }
            }
        }

        $this->variableName = $variableName;
        $this->database = $database;
        $this->conversion = $conversion;
        $this->mergedAssignments = $mergedAssignments;
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

    public function hasMergedAssignments() {
        return !empty($this->mergedAssignments);
    }

    public function getMergedAssignments() {
        return $this->mergedAssignments;
    }

    public function getData() {
        $output = [
            'variable' => $this->getVariableName()
        ];

        if ($this->hasDatabase()) {
            $output['database'] = $this->getDatabase()->getData();
        }

        if ($this->hasConversion()) {
            $output['conversion'] = $this->getConversion()->getData();
        }

        if ($this->hasMergedAssignments()) {
            $mergedAssignments = $this->getMergedAssignments();
            array_walk($mergedAssignments, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['merged_assignments'] = $mergedAssignments;
        }

        return $output;

    }

}
