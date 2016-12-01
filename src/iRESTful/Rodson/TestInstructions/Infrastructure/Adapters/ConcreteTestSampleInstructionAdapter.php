<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Adapters;
use iRESTful\Rodson\TestInstructions\Domain\Containers\Samples\Adapters\TestSampleInstructionAdapter;
use iRESTful\Rodson\TestInstructions\Domain\Containers\Samples\Exceptions\TestSampleInstructionException;
use iRESTful\Rodson\TestInstructions\Domain\Comparisons\Adapters\TestInstructionComparisonAdapter;
use iRESTful\Rodson\Instructions\Domain\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\TestInstructions\Infrastructure\Objects\ConcreteTestSampleInstruction;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;

final class ConcreteTestSampleInstructionAdapter implements TestSampleInstructionAdapter {
    private $instructionAdapterAdapter;
    private $testInstructionComparisonAdapter;
    public function __construct(InstructionAdapterAdapter $instructionAdapterAdapter, TestInstructionComparisonAdapter $testInstructionComparisonAdapter) {
        $this->testInstructionComparisonAdapter = $testInstructionComparisonAdapter;
        $this->instructionAdapterAdapter = $instructionAdapterAdapter;
    }

    public function fromDataToTestSampleInstructions(array $data) {

        if (!isset($data['tests'])) {
            throw new TestSampleInstructionException('The tests keyname is mandatory in order to convert data to SampleInstruction objects.');
        }

        if (!isset($data['controller'])) {
            throw new TestSampleInstructionException('The controller keyname is mandatory in order to convert data to SampleInstruction objects.');
        }

        if (!isset($data['annotated_entities'])) {
            throw new TestSampleInstructionException('The annotated_entities keyname is mandatory in order to convert data to SampleInstruction objects.');
        }

        $commands = [];
        $comparisonCommand = null;

        foreach($data['tests'] as $oneTest) {

            if (strpos($oneTest, '$each->data ') !== false) {
                $oneTest = str_replace('$each->data ', 'input ', $oneTest);
            }

            if (strpos($oneTest, 'compare') !== false) {
                $comparisonCommand = $oneTest;
                continue;
            }

            if (strpos($oneTest, '| not found') !== false) {
                $oneTest = 'retrievedValue = '.str_replace('| not found', '', $oneTest);
                print_r([$oneTest, 'fromDataToTestSampleInstructions']);
                continue;
            }

            $commands[] = $oneTest;

        }

        $instructions = $this->instructionAdapterAdapter->fromDataToInstructionAdapter([
                'annotated_entities' => $data['annotated_entities']
            ])->fromDataToInstructions([
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

        return new ConcreteTestSampleInstruction($instructions, $comparison);

    }

}
