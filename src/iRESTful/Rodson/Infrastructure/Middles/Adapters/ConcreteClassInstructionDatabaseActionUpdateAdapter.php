<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Adapters\UpdateAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionDatabaseActionUpdate;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Updates\Exceptions\UpdateException;

final class ConcreteClassInstructionDatabaseActionUpdateAdapter implements UpdateAdapter {
    private $previousAssignments;
    public function __construct(array $previousAssignments = null) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        $this->previousAssignments = $previousAssignments;

    }

    public function fromStringToUpdate($string) {

        $exploded = explode(' using ', $string);
        if (!isset($exploded[0]) || !isset($exploded[1])) {
            throw new UpdateException('The given update command ('.$string.') is invalid.');
        }

        if (!isset($this->previousAssignments[$exploded[0]])) {
            throw new UpdateException('The given update command ('.$exploded[0].') reference a variable ('.$exploded[0].') that is not defined.');
        }

        if (!isset($this->previousAssignments[$exploded[1]])) {
            throw new UpdateException('The given update command ('.$exploded[0].') reference a variable ('.$exploded[1].') that is not defined.');
        }

        return new ConcreteClassInstructionDatabaseActionUpdate(
            $this->previousAssignments[$exploded[0]],
            $this->previousAssignments[$exploded[1]]
        );
    }

}
