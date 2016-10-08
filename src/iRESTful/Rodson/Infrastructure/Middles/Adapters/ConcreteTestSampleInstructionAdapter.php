<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Samples\Adapters\TestSampleInstructionAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Containers\Samples\Exceptions\TestSampleInstructionException;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Tests\Comparisons\Adapters\TestInstructionComparisonAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Adapters\Adapters\InstructionAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteTestSampleInstruction;
use iRESTful\Objects\Libraries\MetaDatas\Domain\Classes\Repositories\ClassMetaDataRepository;

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
            $oneTest = str_replace('this|container', '$each->container', $oneTest);

            $matches = [];
            preg_match_all('/this->([^ ]+)/s', $oneTest, $matches);

            if (isset($matches[1]) && !empty($matches[1])) {
                foreach($matches[1] as $index => $oneProperty) {

                    if (
                        (strpos($matches[1][$index], ':') !== false) &&
                        (strpos($matches[1][$index], '$property.name$') !== false) &&
                        (strpos($matches[1][$index], 'this->$property.value$') !== false)
                    ) {
                        $matches[1][$index] = str_replace('$property.name$', '$each->data|name', $matches[1][$index]);
                        $oneTest = str_replace('this->$property.value$', '$each->data|value', $matches[1][$index]);

                        continue;
                    }

                    $oneTest = str_replace($matches[0][$index], '$each->data->'.$matches[1][$index], $oneTest);
                }

            }

            if (strpos($oneTest, 'compare') !== false) {
                $comparisonCommand = $oneTest;
                continue;
            }

            if (strpos($oneTest, '| not found') !== false) {
                print_r([$oneTest, 'fromDataToTestSampleInstructions']);
                continue;
                //die();
            }

            $commands[] = $oneTest;

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

        return new ConcreteTestSampleInstruction($instructions, $comparison);

    }

}
