<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Adapters\ToAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionConversionTo;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\From\From;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Conversions\To\Exceptions\ToException;

final class ConcreteClassInstructionConversionToAdapter implements ToAdapter {
    private $annotatedClasses;
    public function __construct(array $annotatedClasses) {
        $this->annotatedClasses = $annotatedClasses;
    }

    public function fromStringToTo($string) {

        $annotatedClasses = $this->annotatedClasses;
        $getAnnotatedClassByObjectName = function($objectName) use(&$annotatedClasses) {

            foreach($annotatedClasses as $oneAnnotatedClass) {
                $oneClass = $oneAnnotatedClass->getClass();
                $input = $oneClass->getInput();
                if (!$input->hasObject()) {
                    continue;
                }

                $object = $input->getObject();
                if ($object->getName() == $objectName) {
                    return $oneAnnotatedClass;
                }
            }

            return null;

        };

        $isMultiple = false;
        if (strpos($string, 'multiple ') === 0) {
            $string = substr($string, strlen('multiple '));
            $isMultiple = true;
        }

        $isPartialSet = false;
        $matches = [];
        preg_match_all('/partial ([^ ]+) list/s', $string, $matches);
        if (isset($matches[0][0]) && ($matches[0][0] == $string)) {
            $string = $matches[1][0];
            $isPartialSet = true;
        }

        $isData = false;
        if ($string == 'data') {
            $isData = true;
        }

        $annotatedClass = $getAnnotatedClassByObjectName($string);
        return new ConcreteClassInstructionConversionTo($isData, $isMultiple, $isPartialSet, $annotatedClass);
    }

}
