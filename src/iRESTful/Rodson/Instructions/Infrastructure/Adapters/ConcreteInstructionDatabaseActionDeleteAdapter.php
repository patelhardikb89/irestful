<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Adapters\DeleteAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseActionDelete;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Deletes\Exceptions\DeleteException;

final class ConcreteInstructionDatabaseActionDeleteAdapter implements DeleteAdapter {
    private $previousAssignments;
    public function __construct(array $previousAssignments = null) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        $this->previousAssignments = $previousAssignments;
    }

    public function fromStringToDelete($string) {

        if (isset($this->previousAssignments[$string])) {
            return new ConcreteInstructionDatabaseActionDelete($this->previousAssignments[$string]);
        }

        if (strpos($string, ', ') !== false) {
            $assignments = [];
            $exploded = explode(', ', $string);
            foreach($exploded as $oneVariable) {

                if (!isset($this->previousAssignments[$oneVariable])) {
                    throw new DeleteException('The given delete action command reference a variable ('.$oneVariable.') that is not defined.');
                }

                $assignments[] = $this->previousAssignments[$oneVariable];
            }

            return new ConcreteInstructionDatabaseActionDelete(null, $assignments);
        }

        throw new DeleteException('The given delete action command reference a variable ('.$string.') that is not defined.');
    }

}
