<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Instructions\Containers\Adapters\ContainerAdapter;
use iRESTful\Rodson\Domain\Inputs\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteClassInstructionContainer;

final class ConcreteClassInstructionContainerAdapter implements ContainerAdapter {
    private $valueAdapter;
    private $annotatedClasses;
    public function __construct(ValueAdapter $valueAdapter, array $annotatedClasses) {
        $this->valueAdapter = $valueAdapter;
        $this->annotatedClasses = $annotatedClasses;
    }

    public function fromStringToContainer($string) {

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

        $value = null;
        $annotatedClass = $getAnnotatedClassByObjectName($string);
        if (empty($annotatedClass)) {
            $value = $this->valueAdapter->fromStringToValue($string);
        }

        return new ConcreteClassInstructionContainer($value, $annotatedClass);
    }

}
