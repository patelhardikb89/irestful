<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Adapters\ElementAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionConversionElement;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\Elements\Exceptions\ElementException;

final class ConcreteClassInstructionConversionElementAdapter implements ElementAdapter {
    private $inputName;
    private $classes;
    private $assignments;
    public function __construct($inputName, array $classes, array $assignments) {
        $this->inputName = $inputName;
        $this->classes = $classes;
        $this->assignments = $assignments;
    }

    public function fromStringToElement($string) {

        $classes = $this->classes;
        $getClassByObjectName = function($objectName) use(&$classes) {

            foreach($classes as $oneClass) {
                $input = $oneClass->getInput();
                if (!$input->hasObject()) {
                    continue;
                }

                $object = $input->getObject();
                if ($object->getName() == $objectName) {
                    return $oneClass;
                }
            }

            return null;

        };

        $assignments = $this->assignments;
        $getAssignmentByVariableName = function($variableName) use(&$assignments) {

            foreach($assignments as $oneAssignment) {

                if ($oneAssignment->getVariableName() == $variableName) {
                    return $oneAssignment;
                }

            }

            return null;

        };

        $isMultiple = false;
        if (strpos($string, 'multiple ') === 0) {
            $string = substr($string, strlen('multiple '));
            $isMultiple = true;
        }

        if ($string == 'data') {
            return new ConcreteClassInstructionConversionElement(true, false, $isMultiple);
        }

        if ($string == $this->inputName) {
            return new ConcreteClassInstructionConversionElement(false, true, $isMultiple);
        }

        $class = $getClassByObjectName($string);
        if (!empty($class)) {
            return new ConcreteClassInstructionConversionElement(false, false, $isMultiple, $class);
        }

        $assignment = $getAssignmentByVariableName($string);
        if (!empty($assignment)) {
            return new ConcreteClassInstructionConversionElement(false, false, $isMultiple, null, $assignment);
        }

        throw new ElementException('The referenced conversion element ('.$string.') could not be identified.');

    }

}
