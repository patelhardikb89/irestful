<?php
namespace iRESTful\Rodson\Instructions\Infrastructure\Adapters;
use iRESTful\Rodson\Instructions\Domain\Adapters\InstructionAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\Rodson\Instructions\Domain\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Rodson\Instructions\Infrastructure\Objects\ConcreteInstruction;
use iRESTful\Rodson\Instructions\Domain\Exceptions\InstructionException;
use iRESTful\Rodson\Instructions\Domain\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;

final class ConcreteInstructionAdapter implements InstructionAdapter {
    private $actionAdapterAdapter;
    private $assignmentAdapterAdapter;
    private $annotatedEntities;
    private $converters;
    public function __construct(
        ActionAdapterAdapter $actionAdapterAdapter,
        AssignmentAdapterAdapter $assignmentAdapterAdapter,
        array $annotatedEntities,
        array $converters
    ) {
        $this->actionAdapterAdapter = $actionAdapterAdapter;
        $this->assignmentAdapterAdapter = $assignmentAdapterAdapter;
        $this->annotatedEntities = $annotatedEntities;
        $this->converters = $converters;
    }

    public function fromDataToInstructions(array $data) {

        if (!isset($data['instructions'])) {
            throw new InstructionException('The instructions keyname is mandatory in order to convert data to Instruction objects.');
        }

        if (!isset($data['controller'])) {
            throw new InstructionException('The controller keyname is mandatory in order to convert data to Instruction objects.');
        }

        $mustReturn = false;
        if (isset($data['must_return'])) {
            $mustReturn = $data['must_return'];
        }

        $httpRequests = null;
        if ($data['controller']->hasHttpRequests()) {
            $httpRequests = $data['controller']->getHttpRequests();
        }

        $assignments = [];
        $returnedInstructions = [];
        $inputName = $data['controller']->getInputName();
        foreach($data['instructions'] as $index => $oneInstruction) {

            $isReturned = false;
            if (strpos($oneInstruction, 'return ') === 0) {
                $isReturned = true;
                $oneInstruction = substr($oneInstruction, strlen('return '));
            }

            if ($isReturned && strpos($oneInstruction, 'merge ') === 0) {
                $remaining = substr($oneInstruction, strlen('merge '));
                $variables = explode(', ', $remaining);

                $merge = [];
                foreach($variables as $oneVariable) {

                    if (!isset($assignments[$oneVariable])) {
                        throw new InstructionException('The variable ('.$oneVariable.') was referenced but never assigned in previous instructions.');
                    }

                    $merge[] = $assignments[$oneVariable];
                }

                $returnedInstructions[$index] = new ConcreteInstruction(null, $merge);
                return $returnedInstructions;
            }

            if ($isReturned && isset($assignments[$oneInstruction])) {
                return $returnedInstructions;
            }

            if (
                (strpos($oneInstruction, 'insert ') === 0) ||
                (strpos($oneInstruction, 'update ') === 0) ||
                (strpos($oneInstruction, 'delete ') === 0) ||
                (strpos($oneInstruction, 'execute ') === 0)
            ) {
                $action = $this->actionAdapterAdapter->fromDataToActionAdapter([
                    'previous_assignments' => $assignments,
                    'http_requests' => $httpRequests
                ])->fromStringToAction($oneInstruction);
                $returnedInstructions[$index] = new ConcreteInstruction(null, null, $action);
                continue;
            }

            $assignment = $this->assignmentAdapterAdapter->fromDataToAssignmentAdapter([
                'annotated_entities' => $this->annotatedEntities,
                'converters' => $this->converters,
                'controller' => $data['controller'],
                'previous_assignments' => $assignments,
                'input' => $inputName
            ])->fromStringToAssignment($oneInstruction);

            $variableName = $assignment->getVariableName();
            $assignments[$variableName] = $assignment;
            $returnedInstructions[$index] = new ConcreteInstruction($assignment);

            if ($isReturned) {
                return $returnedInstructions;
            }
        }

        if ($mustReturn) {
            throw new InstructionException('There was no return clause in the instructions.');
        }

        return $returnedInstructions;

    }

    public function fromDSLControllerToInstructions(Controller $controller) {
        $instructions = $controller->getInstructions();
        return $this->fromDataToInstructions([
            'instructions' => $instructions,
            'controller' => $controller,
            'must_return' => true
        ]);

    }

}
