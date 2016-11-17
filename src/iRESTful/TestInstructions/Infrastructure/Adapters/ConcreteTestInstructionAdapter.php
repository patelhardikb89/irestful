<?php
namespace iRESTful\TestInstructions\Infrastructure\Adapters;
use iRESTful\TestInstructions\Domain\Adapters\TestInstructionAdapter;
use iRESTful\TestInstructions\Domain\Exceptions\TestInstructionException;
use iRESTful\DSLs\Domain\Projects\Controllers\Controller;
use iRESTful\TestInstructions\Domain\Containers\Adapters\TestContainerInstructionAdapter;
use iRESTful\TestInstructions\Infrastructure\Objects\ConcreteTestInstruction;
use iRESTful\Instructions\Domain\Adapters\InstructionAdapter;

final class ConcreteTestInstructionAdapter implements TestInstructionAdapter {
    private $instructionAdapter;
    private $testContainerInstructionAdapter;
    private $annotatedEntities;
    public function __construct(
        InstructionAdapter $instructionAdapter,
        TestContainerInstructionAdapter $testContainerInstructionAdapter,
        array $annotatedEntities
    ) {
        $this->instructionAdapter = $instructionAdapter;
        $this->testContainerInstructionAdapter = $testContainerInstructionAdapter;
        $this->annotatedEntities = $annotatedEntities;
    }

    public function fromDSLControllerToTestInstructions(Controller $controller) {

        if (!$controller->hasTests()) {
            return [];
        }

        $input = [];
        foreach($this->annotatedEntities as $oneAnnotatedEntity) {
            $containerName = $oneAnnotatedEntity->getAnnotation()->getContainerName();
            $containerSamples = $oneAnnotatedEntity->getSamples();
            foreach($containerSamples as $oneSample) {
                $input[] = $oneSample->getData();
            }
        }

        $testInstructions = [];
        $containerInstructions = [];
        $tests = $controller->getTests();
        $inputName = $controller->getInputName();
        foreach($tests as $oneTest) {

            $commands = [];
            foreach($oneTest as $index => $oneCommand) {

                if (is_array($oneCommand)) {

                    $containerInstructions[$index] = $this->testContainerInstructionAdapter->fromDataToTestContainerInstructions([
                        'tests' => $oneCommand,
                        'controller' => $controller,
                        'annotated_entities' => $this->annotatedEntities
                    ]);

                    continue;
                }

                if (strpos($oneCommand, 'this') !== false) {
                    $oneCommand = str_replace('this', $inputName, $oneCommand);
                }

                $commands[$index] = $oneCommand;

            }

            $instructions = $this->instructionAdapter->fromDataToInstructions([
                'controller' => $controller,
                'instructions' => $commands
            ]);

            $testInstructions[] = new ConcreteTestInstruction($instructions, $containerInstructions, $input);

        }

        return $testInstructions;
    }

}
