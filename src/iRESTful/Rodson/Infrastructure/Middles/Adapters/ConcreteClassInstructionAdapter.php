<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\InstructionAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Adapters\Adapters\AssignmentAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstruction;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Exceptions\InstructionException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Databases\Actions\Adapters\Adapters\ActionAdapterAdapter;

final class ConcreteClassInstructionAdapter implements InstructionAdapter {
    private $actionAdapterAdapter;
    private $assignmentAdapterAdapter;
    private $annotatedEntities;
    public function __construct(
        ActionAdapterAdapter $actionAdapterAdapter,
        AssignmentAdapterAdapter $assignmentAdapterAdapter,
        array $annotatedEntities
    ) {
        $this->actionAdapterAdapter = $actionAdapterAdapter;
        $this->assignmentAdapterAdapter = $assignmentAdapterAdapter;
        $this->annotatedEntities = $annotatedEntities;
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
        foreach($data['instructions'] as $oneInstruction) {

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

                $returnedInstructions[] = new ConcreteClassInstruction(null, $merge);
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
                $returnedInstructions[] = new ConcreteClassInstruction(null, null, $action);
                continue;
            }

            $assignment = $this->assignmentAdapterAdapter->fromDataToAssignmentAdapter([
                'annotated_entities' => $this->annotatedEntities,
                'controller' => $data['controller'],
                'previous_assignments' => $assignments,
                'input' => $inputName
            ])->fromStringToAssignment($oneInstruction);

            $variableName = $assignment->getVariableName();
            $assignments[$variableName] = $assignment;
            $returnedInstructions[] = new ConcreteClassInstruction($assignment);

            if ($isReturned) {
                return $returnedInstructions;
            }
        }

        if ($mustReturn) {
            throw new InstructionException('There was no return clause in the instructions.');
        }

        return $returnedInstructions;

    }

    public function fromControllerToInstructions(Controller $controller) {
        $instructions = $controller->getInstructions();
        return $this->fromDataToInstructions([
            'instructions' => $instructions,
            'controller' => $controller,
            'must_return' => true
        ]);

    }

}
