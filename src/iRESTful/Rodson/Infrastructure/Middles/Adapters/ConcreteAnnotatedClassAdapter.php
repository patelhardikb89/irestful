<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\Adapters\AnnotatedClassAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Adapters\ClassAdapter;
use iRESTful\Rodson\Domain\Middles\Annotations\Adapters\AnnotationAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotatedClass;

final class ConcreteAnnotatedClassAdapter implements AnnotatedClassAdapter {
    private $classAdapter;
    private $annotationAdapter;
    public function __construct(ClassAdapter $classAdapter, AnnotationAdapter $annotationAdapter) {
        $this->classAdapter = $classAdapter;
        $this->annotationAdapter = $annotationAdapter;
    }

    public function fromRodsonToAnnotatedClasses(Rodson $rodson) {
        $output = [];
        $classes = $this->classAdapter->fromRodsonToClasses($rodson);
        foreach($classes as $oneClass) {

            $annotation = null;

            try {

                $annotation = $this->annotationAdapter->fromClassToAnnotation($oneClass);

            } catch (\Exception $exception) {

            }

            $output[] = new ConcreteAnnotatedClass($oneClass, $annotation);
        }

        return $output;
    }

}
