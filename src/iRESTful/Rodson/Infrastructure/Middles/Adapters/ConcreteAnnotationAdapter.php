<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Adapters\AnnotationAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Adapters\ParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotation;

final class ConcreteAnnotationAdapter implements AnnotationAdapter {
    private $parameterAdapter;
    public function __construct(ParameterAdapter $parameterAdapter) {
        $this->parameterAdapter = $parameterAdapter;
    }

    public function fromClassToAnnotation(ObjectClass $class) {

        $getName = function(ObjectClass $class) {
            $input = $class->getInput();
            if (!$input->hasObject()) {
                return null;
            }

            return $input->getObject()->getName();
        };

        $name = $getName($class);
        $parameters = $this->parameterAdapter->fromClassToParameters($class);
        return new ConcreteAnnotation($parameters, $name);
    }

}
