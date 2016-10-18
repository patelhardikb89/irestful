<?php
namespace iRESTful\TestInstructions\Infrastructure\Adapters;
use iRESTful\TestInstructions\Domain\CustomMethods\Adapters\CustomMethodAdapter as TestCustomMethodAdapter;
use iRESTful\TestInstructions\Domain\TestInstruction;
use iRESTful\TestInstructions\Comparisons\TestInstructionComparison;
use iRESTful\TestInstructions\Domain\Containers\TestContainerInstruction;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Instructions\Domain\Instruction;
use iRESTful\Instructions\Domain\Assignments\Assignment;
use iRESTful\Instructions\Domain\Databases\Database;
use iRESTful\Instructions\Domain\Databases\Retrievals\Retrieval;
use iRESTful\Instructions\Domain\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Instructions\Domain\Databases\Retrievals\Multiples\MultipleEntity;
use iRESTful\Instructions\Domain\Databases\Retrievals\Entities\Entity;
use iRESTful\Instructions\Domain\Containers\Container;
use iRESTful\DSLs\Domain\Projects\Values\Value;
use iRESTful\Instructions\Domain\Conversions\Conversion;
use iRESTful\TestInstructions\Infrastructure\Objects\ConcreteCustomMethod;
use iRESTful\Instructions\Domain\Values\Value as InstructionValue;
use iRESTful\Classes\Domain\CustomMethods\SourceCodes\Adapters\SourceCodeAdapter;

final class PHPCustomMethodAdapter implements TestCustomMethodAdapter {
    private $customMethodAdapter;
    private $sourceCodeAdapter;
    public function __construct(CustomMethodAdapter $customMethodAdapter, SourceCodeAdapter $sourceCodeAdapter) {
        $this->customMethodAdapter = $customMethodAdapter;
        $this->sourceCodeAdapter = $sourceCodeAdapter;
    }

    public function fromTestInstructionToCustomMethods(TestInstruction $testInstruction) {

        if (!$testInstruction->hasContainerInstructions()) {
            return [];
        }

        $output = [];
        $input = ($testInstruction->hasInput()) ? $testInstruction->getInput() : [];
        $containerInstructions = $testInstruction->getContainerInstructions();
        foreach($containerInstructions as $index => $oneContainerInstruction) {
            $methodName = 'testExecute_'.$index.'_Success';
            $output[] = $this->fromTestContainerInstructionToTestCustomMethod($oneContainerInstruction, $methodName, $input);

        }

        return $output;

    }

    public function fromTestInstructionToTestInitCustomMethod(TestInstruction $testInstruction) {
        $input = ($testInstruction->hasInput()) ? $testInstruction->getInput() : [];
        $instructions = ($testInstruction->hasInstructions()) ?  $testInstruction->getInstructions() : [];
        return $this->fromInstructionsToTestInitCustomMethod($instructions, $input, 'init');
    }

    private function fromTestContainerInstructionToTestCustomMethod(TestContainerInstruction $testContainerInstruction, $methodName, array $input) {

        $methodSourceCodeLines = [];
        if ($testContainerInstruction->hasInstructions()) {
            $instructions = $testContainerInstruction->getInstructions();
            $sourceCodeLines = $this->sourceCodeAdapter->fromDataToSourceCode([
                'instructions' => $instructions
            ])->getLines();

            $comparisonCode = '';
            if ($testContainerInstruction->hasComparison()) {
                $comparisonCode = '$this->assertEquals($oneData, $sourceData);';
            }

            $methodSourceCodeLines[] = [
                '$retrieveSetData = function($container, array $data, $index, $amount) {',
                $sourceCodeLines,
                '}',
                '',
                '$amount = count($this->data);',
                'foreach($this->data as $oneData) {',
                [
                    '$sourceData = $retrieveSetData($oneData[\'container\'], $oneData[\'data\'], 0, $amount);',
                    $comparisonCode
                ],
                '}'
            ];
        }

        if ($testContainerInstruction->hasSampleInstructions()) {
            $sampleInstructions = $testContainerInstruction->getSampleInstructions();
            foreach($sampleInstructions as $oneSampleInstruction) {
                $instructions = $oneSampleInstruction->getInstructions();
                $sourceCodeLines = $this->sourceCodeAdapter->fromDataToSourceCode([
                    'instructions' => $instructions
                ])->getLines();

                $comparisonCode = '';
                if ($oneSampleInstruction->hasComparison()) {
                    $comparisonCode = '$this->assertEquals($oneData, $sourceData);';
                }

                $methodSourceCodeLines[] = [
                    '$retrieveData = function(array $data) {',
                    $sourceCodeLines,
                    '}',
                    '',
                    'foreach($this->data as $oneData) {',
                    [
                        '$sourceData = $retrieveData($oneData);',
                        $comparisonCode
                    ],
                    '}'
                ];

            }

        }

        $functions = [];
        $amount = count($methodSourceCodeLines);
        foreach($methodSourceCodeLines as $index => $oneMethodSourceCodeLines) {

            $delimiter = (($index + 1) >= $amount) ? '' : ',';

            $functions[] = [
                'function() {',
                $oneMethodSourceCodeLines,
                '}'.$delimiter
            ];
        }

        $sourceCodeLines = [
            '$testFunctions = [',
            $functions,
            '];',
            '',
            'foreach($testFunctions as $oneTestFunction) {',
            [
                '$oneTestFunction();'
            ],
            '}'
        ];

        $sourceCode = $this->sourceCodeAdapter->fromSourceCodeLinesToSourceCode($sourceCodeLines);
        return new ConcreteCustomMethod($methodName, $sourceCode);

    }

    private function fromInstructionsToTestInitCustomMethod(array $instructions, array $input, $methodName) {

        return $this->customMethodAdapter->fromDataToCustomMethod([
            'input' => [
                'variable' => '$this->data',
                'data' => $input
            ],
            'instructions' => $instructions,
            'method_name' => 'init'
        ]);

    }

}
