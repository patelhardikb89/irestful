<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Annotations\Adapters\AnnotatedEntityAdapter;
use iRESTful\Rodson\Domain\Middles\Annotations\Adapters\AnnotationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassEntityAnnotated;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\Domain\Middles\Samples\Adapters\SampleAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;

final class ConcreteSpecificClassEntityAnnotatedAdapter implements AnnotatedEntityAdapter {
    private $sampleAdapter;
    private $entityAdapter;
    private $annotationAdapter;
    public function __construct(SampleAdapter $sampleAdapter, EntityAdapter $entityAdapter, AnnotationAdapter $annotationAdapter) {
        $this->sampleAdapter = $sampleAdapter;
        $this->entityAdapter = $entityAdapter;
        $this->annotationAdapter = $annotationAdapter;
    }

    public function fromObjectsToAnnotatedEntities(array $objects) {
        $output = [];
        foreach($objects as $oneObject) {

            if (!$oneObject->hasDatabase()) {
                continue;
            }

            $output[] = $this->fromObjectToAnnotatedEntity($oneObject);
        }

        return $output;
    }

    private function fromObjectToAnnotatedEntity(Object $object) {

        $entity = $this->entityAdapter->fromObjectToEntity($object);
        $annotation = $this->annotationAdapter->fromEntityToAnnotation($entity);

        $data = $object->getSamples();
        array_walk($data, function(&$element, $index) use(&$annotation) {
            $element = [
                'container' => $annotation->getContainerName(),
                'data' => $element->getData()
            ];
        });

        $samples = $this->sampleAdapter->fromDataToSamples($data);
        return new ConcreteSpecificClassEntityAnnotated($entity, $annotation, $samples);
    }

}
