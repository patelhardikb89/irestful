<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\Adapters\FromAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionConversionFrom;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Assignments\Assignment;

final class ConcreteClassInstructionConversionFromAdapter implements FromAdapter {
    private $inputName;
    private $assignments;
    public function __construct($inputName, array $assignments) {
        $this->inputName = $inputName;
        $this->assignments = $assignments;
    }

    public function fromStringToFrom($string) {

        $assignments = $this->assignments;
        $getAssignmentByVariableName = function($variableName) use(&$assignments) {

            foreach($assignments as $oneAssignment) {

                if ($oneAssignment->getVariableName() == $variableName) {
                    return $oneAssignment;
                }

            }

            return null;

        };

        $isInput = false;
        $inputKeynames = [];
        if (strpos($string, $this->inputName) !== false) {
            $isInput = true;
            $exploded = explode('->', $string);
            foreach($exploded as $oneExploded) {
                if ($oneExploded == $this->inputName) {
                    continue;
                }

                $inputKeynames[] = $oneExploded;
            }
        }

        $assignment = $getAssignmentByVariableName($string);
        return new ConcreteClassInstructionConversionFrom($isInput, $inputKeynames, $assignment);
    }

}
