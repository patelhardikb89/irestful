<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Databases\Actions\Inserts\Adapters\InsertAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionDatabaseActionInsert;
use iRESTful\Instructions\Domain\Databases\Actions\Inserts\Exceptions\InsertException;

final class ConcreteInstructionDatabaseActionInsertAdapter implements InsertAdapter {
    private $previousAssignments;
    public function __construct(array $previousAssignments = null) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        $this->previousAssignments = $previousAssignments;
    }

    public function fromStringToInsert($string) {

        if (isset($this->previousAssignments[$string])) {
            return new ConcreteInstructionDatabaseActionInsert($this->previousAssignments[$string]);
        }

        if (strpos($string, ', ') !== false) {
            $assignments = [];
            $exploded = explode(', ', $string);
            foreach($exploded as $oneVariable) {

                if (!isset($this->previousAssignments[$oneVariable])) {
                    throw new InsertException('The given insert action command reference a variable ('.$oneVariable.') that is not defined.');
                }

                $assignments[] = $this->previousAssignments[$oneVariable];
            }

            return new ConcreteInstructionDatabaseActionInsert(null, $assignments);
        }

        throw new InsertException('The given insert action command reference a variable ('.$string.') that is not defined.');
    }

}
