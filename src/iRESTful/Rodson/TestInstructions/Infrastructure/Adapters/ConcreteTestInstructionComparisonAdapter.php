<?php
namespace iRESTful\Rodson\TestInstructions\Infrastructure\Adapters;
use iRESTful\Rodson\TestInstructions\Domain\Comparisons\Adapters\TestInstructionComparisonAdapter;
use iRESTful\Rodson\TestInstructions\Domain\Comparisons\Exceptions\TestInstructionComparisonException;
use iRESTful\Rodson\TestInstructions\Infrastructure\Objects\ConcreteTestInstructionComparison;

final class ConcreteTestInstructionComparisonAdapter implements TestInstructionComparisonAdapter {

    public function __construct() {

    }

    public function fromDataToComparison(array $data) {

        $getInstruction = function($variableName, array $instructions) {

            foreach($instructions as $oneInstruction) {

                if ($oneInstruction->hasAssignment()) {
                    if ($oneInstruction->getAssignment()->getVariableName()) {
                        return $oneInstruction;
                    }
                }

            }

            return null;

        };

        if (!isset($data['command'])) {
            throw new TestInstructionComparisonException('The command keyname is mandatory in order to convert data to a Comparison object.');
        }

        if (!isset($data['instructions'])) {
            throw new TestInstructionComparisonException('The instructions keyname is mandatory in order to convert data to a Comparison object.');
        }

        $matches = [];
        preg_match_all('/compare ([^ ]+) to ([^ ]+)/s', $data['command'], $matches);
        if (!isset($matches[1][0]) || !isset($matches[2][0])) {
            throw new TestInstructionComparisonException('The given comparison command ('.$data['command'].') is invalid.');
        }

        $sample = null;
        $samples = [
            'some' => 'test'
        ];;

        /*$sample = null;
        if (isset($data['sample'])) {
            $sample = $data['sample'];
        }

        $samples = null;
        if (isset($data['samples'])) {
            $samples = $data['samples'];
        }*/

        if ($matches[1][0] == 'this') {
            $instruction = $getInstruction($matches[2][0], $data['instructions']);
            return new ConcreteTestInstructionComparison($instruction, $sample, $samples);
        }

        if ($matches[2][0] == 'this') {
            $instruction = $getInstruction($matches[1][0], $data['instructions']);
            return new ConcreteTestInstructionComparison($instruction, $sample, $samples);
        }

        $instruction = $getInstruction($matches[1][0], $data['instructions']);
        $secondnstruction = $getInstruction($matches[2][0], $data['instructions']);
        return new ConcreteTestInstructionComparison($instruction, null, null, $secondnstruction);
    }

}
