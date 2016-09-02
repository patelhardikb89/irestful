<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Adapters\InsertAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseActionInsert;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Inserts\Exceptions\InsertException;

final class ConcreteClassInstructionDatabaseActionInsertAdapter implements InsertAdapter {
    private $previousAssignments;
    public function __construct(array $previousAssignments = null) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        $this->previousAssignments = $previousAssignments;
    }

    public function fromStringToInsert($string) {

        if (isset($this->previousAssignments[$string])) {
            return new ConcreteClassInstructionDatabaseActionInsert($this->previousAssignments[$string]);
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

            return new ConcreteClassInstructionDatabaseActionInsert(null, $assignments);
        }

        throw new InsertException('The given insert action command reference a variable ('.$string.') that is not defined.');
    }

}
