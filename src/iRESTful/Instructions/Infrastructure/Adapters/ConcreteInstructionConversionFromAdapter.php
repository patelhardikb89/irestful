<?php
namespace iRESTful\Instructions\Infrastructure\Adapters;
use iRESTful\Instructions\Domain\Conversions\From\Adapters\FromAdapter;
use iRESTful\Instructions\Infrastructure\Objects\ConcreteInstructionConversionFrom;
use iRESTful\Instructions\Domain\Assignments\Assignment;

final class ConcreteInstructionConversionFromAdapter implements FromAdapter {
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
        return new ConcreteInstructionConversionFrom($isInput, $inputKeynames, $assignment);
    }

}
