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

        throw new InsertException('The given insert action command reference a variable ('.$string.') that is not defined.');
    }

}
