<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Adapters\DeleteAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseActionDelete;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Deletes\Exceptions\DeleteException;

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

        throw new DeleteException('The given delete action command reference a variable ('.$string.') that is not defined.');
    }

}
