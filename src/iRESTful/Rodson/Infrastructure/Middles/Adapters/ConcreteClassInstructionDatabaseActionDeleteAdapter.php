<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters\DeleteAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseActionDelete;

final class ConcreteClassInstructionDatabaseActionDeleteAdapter implements DeleteAdapter {
    private $previousAssignments;
    public function __construct(array $previousAssignments = null) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        $this->previousAssignments = $previousAssignments;
    }

    public function fromStringToDelete($string) {

        if (isset($this->previousAssignments[$string])) {
            return new ConcreteClassInstructionDatabaseActionDelete($this->previousAssignments[$string]);
        }
        print_r([$string, 'delete']);
        die();
    }

}
