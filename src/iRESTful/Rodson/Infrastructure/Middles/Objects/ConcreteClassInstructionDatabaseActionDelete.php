<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Delete;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Exceptions\DeleteException;

final class ConcreteClassInstructionDatabaseActionDelete implements Delete {
    private $assignment;
    private $assignments;
    public function __construct(Assignment $assignment = null, array $assignments = null) {

        if (empty($assignments)) {
            $assignments = null;
        }

        $amount = (empty($assignment) ? 0 : 1) + (empty($assignments) ? 0 : 1);
        if ($amount != 1) {
            throw new DeleteException('One of these must be non-empty: assignment, assignments.  '.$amount.' given.');
        }

        $this->assignment = $assignment;
        $this->assignments = $assignments;

    }

    public function hasAssignment() {
        return !empty($this->assignment);
    }

    public function getAssignment() {
        return $this->assignment;
    }

    public function hasAssignments() {
        return !empty($this->assignments);
    }

    public function getAssignments() {
        return $this->assignments;
    }
}
