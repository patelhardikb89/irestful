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

        $getIsData = function(Assignment $assignment = null) {

            if (empty($assignment)) {
                return true;
            }

            if ($assignment->hasDatabase()) {
                $database = $assignment->getDatabase();
                if (!$database->hasRetrieval()) {
                    //throws
                }

                $retrieval = $database->getRetrieval();
                if ($retrieval->hasHttpRequest()) {
                    return true;
                }

                return false;
            }

            if ($assignment->hasMergedAssignments()) {
                return true;
            }

            if ($assignment->hasConversion()) {
                return $assignment->getConversion()->to()->isData();
            }

            //throws

        };

        $getIsMultiple = function(Assignment $assignment = null) {
            if (empty($assignment)) {
                return false;
            }

            if ($assignment->hasDatabase()) {
                $database = $assignment->getDatabase();
                if (!$database->hasRetrieval()) {
                    //throws
                }

                $retrieval = $database->getRetrieval();
                if ($retrieval->hasMultipleEntities()) {
                    return true;
                }

                return false;
            }

            if ($assignment->hasMergedAssignments()) {
                return true;
            }

            if ($assignment->hasConversion()) {
                return $assignment->getConversion()->to()->isMultiple();
            }

            //throws
        };

        $assignment = $getAssignmentByVariableName($string);
        $isData = $getIsData($assignment);
        $isMultiple = $getIsMultiple($assignment);
        $isInput = ($this->inputName == $string);

        return new ConcreteClassInstructionConversionFrom($isData, $isInput, $isMultiple, $assignment);
    }

}
