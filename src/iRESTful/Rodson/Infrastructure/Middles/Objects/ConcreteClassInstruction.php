<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Instruction;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Database;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Conversion;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Exceptions\InstructionException;

final class ConcreteClassInstruction implements Instruction {
    private $database;
    private $conversion;
    private $assignment;
    private $mergedAssignments;
    public function __construct(Database $database = null, Conversion $conversion = null, Assignment $assignment = null, array $mergedAssignments = null) {

        if (empty($mergedAssignments)) {
            $mergedAssignments = null;
        }

        $amount = (empty($database) ? 0 : 1) + (empty($conversion) ? 0 : 1) + (empty($assignment) ? 0 : 1) + (empty($mergedAssignments) ? 0 : 1);
        if ($amount != 1) {
            throw new InstructionException('One of these must be non-empty: database, coversion, assignment, mergedAssignments.  '.$amount.' given.');
        }

        if (!empty($mergedAssignments)) {
            foreach($mergedAssignments as $oneMergedAssignment) {
                if (!($oneMergedAssignment instanceof Assignment)) {
                    throw new InstructionException('The mergedAssignments array must only contain Assignment objects.');
                }
            }
        }

        $this->database = $database;
        $this->conversion = $conversion;
        $this->assignment = $assignment;
        $this->mergedAssignments = $mergedAssignments;

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

    public function hasMergeAssignments() {
        return !empty($this->mergedAssignments);
    }

    public function getMergeAssignments() {
        return $this->mergedAssignments;
    }

    public function hasAssignment() {
        return !empty($this->assignment);
    }

    public function getAssignment() {
        return $this->assignment;
    }

}
