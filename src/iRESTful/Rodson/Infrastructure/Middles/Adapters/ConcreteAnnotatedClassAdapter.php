<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Annotations\Classes\Adapters\AnnotatedClassAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Adapters\ClassAdapter;
use iRESTful\Rodson\Domain\Middles\Annotations\Adapters\AnnotationAdapter;
use iRESTful\Rodson\Domain\Inputs\Rodson;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteAnnotatedClass;
use iRESTful\Rodson\Domain\Middles\Samples\Adapters\SampleAdapter;

final class ConcreteAnnotatedClassAdapter implements AnnotatedClassAdapter {
    private $classAdapter;
    private $annotationAdapter;
    private $sampleAdapter;
    public function __construct(ClassAdapter $classAdapter, AnnotationAdapter $annotationAdapter, SampleAdapter $sampleAdapter) {
        $this->classAdapter = $classAdapter;
        $this->annotationAdapter = $annotationAdapter;
        $this->sampleAdapter = $sampleAdapter;
    }

    public function fromRodsonToAnnotatedClasses(Rodson $rodson) {
        $output = [];
        $classes = $this->classAdapter->fromRodsonToClasses($rodson);
        foreach($classes as $oneClass) {

            $annotation = null;
            $samples = null;

            try {

                $annotation = $this->annotationAdapter->fromClassToAnnotation($oneClass);

                if ($annotation->hasContainerName()) {
                    $input = $oneClass->getInput();
                    if ($input->hasObject()) {
                        $object = $input->getObject();
                        if ($object->hasSamples()) {
                            $samples = [];
                            $objectSamples = $object->getSamples();
                            foreach($objectSamples as $oneObjectSample) {
                                $samples[] = $this->sampleAdapter->fromDataToSample([
                                    'container' => $annotation->getContainerName(),
                                    'data' => $oneObjectSample->getData()
                                ]);
                            }
                        }
                    }
                }


            } catch (\Exception $exception) {

            }

            $output[] = new ConcreteAnnotatedClass($oneClass, $annotation, $samples);
        }

        return $output;
    }

}
