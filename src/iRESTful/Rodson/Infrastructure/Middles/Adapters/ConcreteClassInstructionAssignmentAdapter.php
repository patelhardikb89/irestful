<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters\AssignmentAdapter;
use iRESTful\Rodson\Domain\Inputs\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Adapters\DatabaseAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Adapters\Adapters\ConversionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionAssignment;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Exceptions\AssignmentException;

final class ConcreteClassInstructionAssignmentAdapter implements AssignmentAdapter {
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

            return new ConcreteClassInstructionAssignment($variableName, null, null, $merge);

        }

        $database = null;
        if (empty($conversion)) {
            $database = $this->databaseAdapter->fromStringToDatabase($command);
        }

        return new ConcreteClassInstructionAssignment($variableName, $database, $conversion);

    }

}
