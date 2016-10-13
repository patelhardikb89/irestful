<?php
namespace iRESTful\ClassesEntitiesAnnotations\Infrastructure\Adapters;
use iRESTful\ClassesEntitiesAnnotations\Domain\Adapters\AnnotatedEntityAdapter;
use iRESTful\Annotations\Domain\Adapters\AnnotationAdapter;
use iRESTful\ClassesEntitiesAnnotations\Infrastructure\Objects\ConcreteAnnotatedEntity;
use iRESTful\ClassesEntities\Domain\Adapters\EntityAdapter;
use iRESTful\Classes\Domain\Samples\Adapters\SampleAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;

final class ConcreteAnnotatedEntityAdapter implements AnnotatedEntityAdapter {
    private $sampleAdapter;
    private $entityAdapter;
    private $annotationAdapter;
    public function __construct(SampleAdapter $sampleAdapter, EntityAdapter $entityAdapter, AnnotationAdapter $annotationAdapter) {
        $this->sampleAdapter = $sampleAdapter;
        $this->entityAdapter = $entityAdapter;
        $this->annotationAdapter = $annotationAdapter;
    }

    public function fromDSLObjectsToAnnotatedEntities(array $objects) {
        $output = [];
        foreach($objects as $oneObject) {

            if (!$oneObject->hasDatabase()) {
                continue;
            }

            $output[] = $this->fromDSLObjectToAnnotatedEntity($oneObject);
        }

        return $output;
    }

    public function fromDSLObjectToAnnotatedEntity(Object $object) {

        $entity = $this->entityAdapter->fromDSLObjectToEntity($object);
        $annotation = $this->annotationAdapter->fromEntityToAnnotation($entity);

        $data = $object->getSamples();
        array_walk($data, function(&$element, $index) use(&$annotation) {
            $element = [
                'container' => $annotation->getContainerName(),
                'data' => $element->getData()
            ];
        });

        $samples = $this->sampleAdapter->fromDataToSamples($data);
        return new ConcreteAnnotatedEntity($entity, $annotation, $samples);
    }

}
