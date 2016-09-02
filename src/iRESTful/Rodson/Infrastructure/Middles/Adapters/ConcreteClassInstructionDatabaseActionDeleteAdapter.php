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

        if (strpos($string, ', ') !== false) {
            $assignments = [];
            $exploded = explode(', ', $string);
            foreach($exploded as $oneVariable) {

                if (!isset($this->previousAssignments[$oneVariable])) {
                    throw new DeleteException('The given delete action command reference a variable ('.$oneVariable.') that is not defined.');
                }

                $assignments[] = $this->previousAssignments[$oneVariable];
            }

            return new ConcreteClassInstructionDatabaseActionDelete(null, $assignments);
        }

        throw new DeleteException('The given delete action command reference a variable ('.$string.') that is not defined.');
    }

}
