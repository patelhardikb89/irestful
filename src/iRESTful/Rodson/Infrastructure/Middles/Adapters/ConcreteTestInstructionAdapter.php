<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Adapters\TestInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Exceptions\TestInstructionException;
use iRESTful\Rodson\Domain\Inputs\Projects\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Adapters\TestContainerInstructionAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteTestInstruction;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\InstructionAdapter;

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

    public function fromControllerToTestInstructions(Controller $controller) {

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

            foreach($oneTest as $oneCommand) {

                if (is_array($oneCommand)) {

                    $containerInstructions[] = $this->testContainerInstructionAdapter->fromDataToTestContainerInstructions([
                        'tests' => $oneCommand,
                        'controller' => $controller,
                        'annotated_entities' => $this->annotatedEntities
                    ]);

                    continue;
                }

                if (strpos($oneCommand, 'this') !== false) {
                    $oneCommand = str_replace('this', $inputName, $oneCommand);
                }

                $commands[] = $oneCommand;

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
