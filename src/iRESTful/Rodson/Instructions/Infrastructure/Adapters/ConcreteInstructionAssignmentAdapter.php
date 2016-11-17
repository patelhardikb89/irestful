<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Assignments\Adapters\AssignmentAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\Instructions\Domain\Databases\Adapters\DatabaseAdapter;
use iRESTful\Rodson\Instructions\Domain\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstructionAssignment;
use iRESTful\Rodson\Instructions\Domain\Assignments\Exceptions\AssignmentException;

final class ConcreteInstructionAssignmentAdapter implements AssignmentAdapter {
    private $databaseAdapter;
    private $conversionAdapterAdapter;
    private $inputName;
    private $annotatedEntities;
    private $previousAssignments;
    public function __construct(
        DatabaseAdapter $databaseAdapter,
        ConversionAdapterAdapter $conversionAdapterAdapter,
        $inputName,
        array $annotatedEntities,
        array $previousAssignments = null
    ) {

        if (empty($previousAssignments)) {
            $previousAssignments = [];
        }

        $this->databaseAdapter = $databaseAdapter;
        $this->conversionAdapterAdapter = $conversionAdapterAdapter;
        $this->inputName = $inputName;
        $this->annotatedEntities = $annotatedEntities;
        $this->previousAssignments = $previousAssignments;
    }

    public function fromStringToAssignment($string) {

        if (strpos($string, ' = ') === false) {
            throw new AssignmentException('The command ('.$string.') must contain an equal sign with space in prefix and suffix ( = ) in order to be an assignment.');
        }

        $exploded = explode(' = ', $string);
        $variableName = $exploded[0];
        $command = $exploded[1];

        $conversion = null;
        if (strpos($command, 'from ') === 0) {
            $conversion = $this->conversionAdapterAdapter->fromDataToConversionAdapter([
                'annotated_entities' => $this->annotatedEntities,
                'previous_assignments' => $this->previousAssignments,
                'input' => $this->inputName
            ])->fromStringToConversion($command);
        }

        if (strpos($command, 'merge ') === 0) {
            $remaining = substr($command, strlen('merge '));
            $variables = explode(', ', $remaining);

            $merge = [];
            foreach($variables as $oneVariable) {

                if (!isset($this->previousAssignments[$oneVariable])) {
                    throw new AssignmentException('The variable ('.$oneVariable.') was referenced but never assigned in previous instructions.');
                }

                $merge[] = $this->previousAssignments[$oneVariable];
            }

            return new ConcreteInstructionAssignment($variableName, null, null, $merge);

        }

        $database = null;
        if (empty($conversion)) {
            $database = $this->databaseAdapter->fromStringToDatabase($command);
        }

        return new ConcreteInstructionAssignment($variableName, $database, $conversion);

    }

}
