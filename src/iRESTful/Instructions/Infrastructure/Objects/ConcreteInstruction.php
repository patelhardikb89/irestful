<?php
namespace iRESTful\Instructions\Infrastructure\Objects;
use iRESTful\Instructions\Domain\Instruction;
use iRESTful\Instructions\Domain\Assignments\Assignment;
use iRESTful\Instructions\Domain\Exceptions\InstructionException;
use iRESTful\Instructions\Domain\Databases\Actions\Action;

final class ConcreteInstruction implements Instruction {
    private $assignment;
    private $mergedAssignments;
    private $action;
    public function __construct(Assignment $assignment = null, array $mergedAssignments = null, Action $action = null) {

        if (empty($mergedAssignments)) {
            $mergedAssignments = null;
        }

        $amount = (empty($assignment) ? 0 : 1) + (empty($action) ? 0 : 1) + (empty($mergedAssignments) ? 0 : 1);
        if ($amount != 1) {
            throw new InstructionException('One of these must be non-empty: action, assignment, mergedAssignments.  '.$amount.' given.');
        }

        if (!empty($mergedAssignments)) {
            foreach($mergedAssignments as $oneMergedAssignment) {
                if (!($oneMergedAssignment instanceof Assignment)) {
                    throw new InstructionException('The mergedAssignments array must only contain Assignment objects.');
                }
            }
        }

        $this->assignment = $assignment;
        $this->mergedAssignments = $mergedAssignments;
        $this->action = $action;
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

    public function hasAction() {
        return !empty($this->action);
    }

    public function getAction() {
        return $this->action;
    }

}
