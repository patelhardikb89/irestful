<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Adapters;
use iRESTful\Rodson\TestInstructions\Domain\CustomMethods\Adapters\CustomMethodAdapter as TestCustomMethodAdapter;
use iRESTful\Rodson\TestInstructions\Domain\TestInstruction;
use iRESTful\Rodson\TestInstructions\Comparisons\TestInstructionComparison;
use iRESTful\Rodson\TestInstructions\Domain\Containers\TestContainerInstruction;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Instructions\Domain\Instruction;
use iRESTful\Rodson\Instructions\Domain\Assignments\Assignment;
use iRESTful\Rodson\Instructions\Domain\Databases\Database;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Retrieval;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\EntityPartialSets\EntityPartialSet;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Multiples\MultipleEntity;
use iRESTful\Rodson\Instructions\Domain\Databases\Retrievals\Entities\Entity;
use iRESTful\Rodson\Instructions\Domain\Containers\Container;
use iRESTful\Rodson\DSLs\Domain\Projects\Values\Value;
use iRESTful\Rodson\Instructions\Domain\Conversions\Conversion;
use iRESTful\Rodson\TestInstructions\Infrastructure\Objects\ConcreteCustomMethod;
use iRESTful\Rodson\Instructions\Domain\Values\Value as InstructionValue;
use iRESTful\Rodson\Classes\Domain\CustomMethods\SourceCodes\Adapters\SourceCodeAdapter;

final class PHPCustomMethodAdapter implements TestCustomMethodAdapter {
    private $customMethodAdapter;
    private $sourceCodeAdapter;
    public function __construct(CustomMethodAdapter $customMethodAdapter, SourceCodeAdapter $sourceCodeAdapter) {
        $this->customMethodAdapter = $customMethodAdapter;
        $this->sourceCodeAdapter = $sourceCodeAdapter;
    }

    public function fromTestInstructionToCustomMethods(TestInstruction $testInstruction) {

        $getActiveInstructions = function(array $containerInstructions, array $instructions) {

            $keys = array_keys($containerInstructions);
            $firstContainerIndex = $keys[0];

            $output = [];
            foreach($instructions as $index => $oneInstruction) {

                if ($index < $firstContainerIndex) {
                    continue;
                }

                $output[$index] = $oneInstruction;
            }

            return $output;
        };

        $getBeginIndex = function(array $containerInstructions, array $instructions) {
            $containerKeys = array_keys($containerInstructions);
            $instructionKeys = array_keys($instructions);

            if ($containerKeys[0] < $instructionKeys[0]) {
                return $containerKeys[0];
            }

            return $instructionKeys[0];
        };

        $getEndIndex = function(array $containerInstructions, array $instructions) {
            $containerKeys = array_keys($containerInstructions);
            $instructionKeys = array_keys($instructions);

            if ($containerKeys[0] > $instructionKeys[0]) {
                return $containerKeys[0];
            }

            return $instructionKeys[0];
        };

        if (!$testInstruction->hasContainerInstructions()) {
            return [];
        }

        $activeInstructions = [];
        $containerInstructions = $testInstruction->getContainerInstructions();
        $containerInstructionKeys = array_keys($containerInstructions);

        $beginIndex = $containerInstructionKeys[0];
        $endIndex = $containerInstructionKeys[count($containerInstructionKeys) - 1];

        if ($testInstruction->hasInstructions()) {
            $instructions = $testInstruction->getInstructions();
            $activeInstructions = $getActiveInstructions($containerInstructions, $instructions);

            $beginIndex = $getBeginIndex($containerInstructions, $activeInstructions);
            $endIndex = $getEndIndex($containerInstructions, $activeInstructions);
        }

        $methodLines = [];
        for($i = $beginIndex; $i <= $endIndex; $i++) {

            $sourceCode = null;
            if (isset($containerInstructions[$i])) {
                $sourceCode = $this->fromTestContainerInstructionToSourceCode($containerInstructions[$i]);
            }

            if (isset($activeInstructions[$i])) {
                $sourceCode = $this->sourceCodeAdapter->fromInstructionsToSourceCode([$activeInstructions[$i]]);
            }

            if (empty($sourceCode)) {
                //throws
            }

            if (!$sourceCode->hasLines()) {
                continue;
            }

            $lines = $sourceCode->getLines();
            $methodLines = array_merge($methodLines, [''], $lines);

        }

        $sourceCode = $this->sourceCodeAdapter->fromSourceCodeLinesToSourceCode($methodLines);

        $output = [];
        $output[] = new ConcreteCustomMethod('testExecute_Success', $sourceCode);
        return $output;

    }

    public function fromTestInstructionToTestInitCustomMethod(TestInstruction $testInstruction) {
        $input = ($testInstruction->hasInput()) ? $testInstruction->getInput() : [];
        $instructions = ($testInstruction->hasInstructions()) ?  $testInstruction->getInstructions() : [];
        return $this->fromInstructionsToTestInitCustomMethod($instructions, $input, 'init');
    }

    /*private function fromTestContainerInstructionToTestCustomMethod(TestContainerInstruction $testContainerInstruction, $methodName, array $input) {

        $methodSourceCodeLines = [];
        if ($testContainerInstruction->hasInstructions()) {
            $instructions = $testContainerInstruction->getInstructions();
            $sourceCodeLines = $this->sourceCodeAdapter->fromDataToSourceCode([
                'instructions' => $instructions
            ])->getLines();

            $comparisonCode = '';
            if ($testContainerInstruction->hasComparison()) {
                $comparisonCode = '$this->assertEquals($retrieved, $source);';
            }

            $methodSourceCodeLines[] = [
                '$retrieveSet = function($container, array $data, $index, $amount) {',
                $sourceCodeLines,
                '}',
                '',
                '$amount = count($this->data);',
                'foreach($this->data as $oneData) {',
                [
                    '$retrievedSet = $retrieveSet($oneData[\'container\'], $oneData[\'data\'], 0, $amount);',
                    '$sourceSet = $this->entityAdapterFactory->create()->fromDataToEntitySet($oneData, true);',
                    $comparisonCode
                ],
                '}'
            ];
        }

        if ($testContainerInstruction->hasSampleInstructions()) {
            $sampleInstructions = $testContainerInstruction->getSampleInstructions();
            foreach($sampleInstructions as $oneSampleInstruction) {

                $sourceCodeLines = [];
                if ($oneSampleInstruction->hasInstructions()) {
                    $instructions = $oneSampleInstruction->getInstructions();
                    $sourceCodeLines = $this->sourceCodeAdapter->fromDataToSourceCode([
                        'instructions' => $instructions
                    ])->getLines();
                }

                $comparisonCode = '';
                if ($oneSampleInstruction->hasComparison()) {
                    $comparisonCode = '$this->assertEquals($retrieved, $source);';
                }

                $methodSourceCodeLines[] = [
                    '$retrieveEntity = function(array $input) {',
                    $sourceCodeLines,
                    '};',
                    '',
                    'foreach($this->data as $oneData) {',
                    [
                        '$retrieved = $retrieveEntity($oneData);',
                        '$source = $this->entityAdapterFactory->create()->fromDataToEntity($oneData, true);',
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

    }*/

    private function fromTestContainerInstructionToSourceCode(TestContainerInstruction $testContainerInstruction) {

        $methodSourceCodeLines = [];
        if ($testContainerInstruction->hasInstructions()) {
            $instructions = $testContainerInstruction->getInstructions();
            $sourceCodeLines = $this->sourceCodeAdapter->fromDataToSourceCode([
                'instructions' => $instructions
            ])->getLines();

            $comparisonCode = '';
            if ($testContainerInstruction->hasComparison()) {
                $comparisonCode = '$this->assertEquals($retrieved, $source);';
            }

            $methodSourceCodeLines[] = [
                '$retrieveSet = function($container, array $data, $index, $amount) {',
                $sourceCodeLines,
                '}',
                '',
                '$amount = count($this->data);',
                'foreach($this->data as $oneData) {',
                [
                    '$retrievedSet = $retrieveSet($oneData[\'container\'], $oneData[\'data\'], 0, $amount);',
                    '$sourceSet = $this->entityAdapterFactory->create()->fromDataToEntitySet($oneData, true);',
                    $comparisonCode
                ],
                '}'
            ];
        }

        if ($testContainerInstruction->hasSampleInstructions()) {
            $sampleInstructions = $testContainerInstruction->getSampleInstructions();
            foreach($sampleInstructions as $oneSampleInstruction) {

                $sourceCodeLines = [];
                if ($oneSampleInstruction->hasInstructions()) {
                    $instructions = $oneSampleInstruction->getInstructions();
                    $sourceCodeLines = $this->sourceCodeAdapter->fromDataToSourceCode([
                        'instructions' => $instructions
                    ])->getLines();
                }

                $comparisonCode = '';
                if ($oneSampleInstruction->hasComparison()) {
                    $comparisonCode = '$this->assertEquals($retrieved, $source);';
                }

                $methodSourceCodeLines[] = [
                    '$retrieveEntity = function(array $input) {',
                    $sourceCodeLines,
                    '};',
                    '',
                    'foreach($this->data as $oneData) {',
                    [
                        '$retrieved = $retrieveEntity($oneData);',
                        '$source = $this->entityAdapterFactory->create()->fromDataToEntity($oneData, true);',
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

        return $this->sourceCodeAdapter->fromSourceCodeLinesToSourceCode($sourceCodeLines);

    }

    private function fromInstructionsToTestInitCustomMethod(array $instructions, array $input, $methodName) {

        $getInitInstructions = function() use(&$instructions) {
            $lastIndex = -1;
            $initInstructions = [];
            foreach($instructions as $index => $oneInstruction) {

                if (($index - 1) == $lastIndex) {
                    $initInstructions[] = $oneInstruction;
                    $lastIndex = $index;
                    continue;
                }

                return $initInstructions;
            }

            return $initInstructions;
        };

        return $this->customMethodAdapter->fromDataToCustomMethod([
            'input' => [
                'variable' => '$this->data',
                'data' => $input
            ],
            'instructions' => $getInitInstructions(),
            'method_name' => 'init'
        ]);

    }

}
