<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Adapters\TestContainerInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Exceptions\TestContainerInstructionException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Samples\Adapters\TestSampleInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Comparisons\Adapters\TestInstructionComparisonAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteTestContainerInstruction;

final class ConcreteTestContainerInstructionAdapter implements TestContainerInstructionAdapter {
    private $instructionAdapterAdapter;
    private $testSampleInstructionAdapter;
    private $testInstructionComparisonAdapter;
    public function __construct(
        InstructionAdapterAdapter $instructionAdapterAdapter,
        TestSampleInstructionAdapter $testSampleInstructionAdapter,
        TestInstructionComparisonAdapter $testInstructionComparisonAdapter
    ) {
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
        $this->testSampleInstructionAdapter = $testSampleInstructionAdapter;
        $this->testInstructionComparisonAdapter = $testInstructionComparisonAdapter;
    }

    public function fromDataToTestContainerInstructions(array $data) {

        if (!isset($data['tests'])) {
            throw new TestContainerInstructionException('The tests keyname is mandatory in order to convert data to a ContainerInstruction object.');
        }

        if (!isset($data['controller'])) {
            throw new TestContainerInstructionException('The controller keyname is mandatory in order to convert data to a ContainerInstruction object.');
        }

        if (!isset($data['annotated_entities'])) {
            throw new TestContainerInstructionException('The annotated_entities keyname is mandatory in order to convert data to a ContainerInstruction object.');
        }

        $commands = [];
        $sampleInstructions = [];
        $comparisonCommand = null;
        foreach($data['tests'] as $oneTest) {

            if (is_string($oneTest)) {

                if (strpos($oneTest, 'compare ') !== false) {
                    $comparisonCommand = $oneTest;
                    continue;
                }

                $commands[] = $oneTest;
                continue;
            }

            $sampleInstructions[] = $this->testSampleInstructionAdapter->fromDataToTestSampleInstructions([
                'tests' => $oneTest,
                'controller' => $data['controller'],
                'annotated_entities' => $data['annotated_entities']
            ]);

        }


        $instructions = $this->instructionAdapterAdapter->fromAnnotatedEntitiesToInstructionAdapter($data['annotated_entities'])->fromDataToInstructions([
            'controller' => $data['controller'],
            'instructions' => $commands
        ]);

        $comparison = null;
        if (!empty($comparisonCommand)) {
            $comparison = $this->testInstructionComparisonAdapter->fromDataToComparison([
                'command' => $comparisonCommand,
                'instructions' => $instructions
            ]);
        }

        return new ConcreteTestContainerInstruction($instructions, $sampleInstructions, $comparison);

    }

}
