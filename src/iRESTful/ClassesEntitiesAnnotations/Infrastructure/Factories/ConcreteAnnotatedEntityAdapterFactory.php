<?php
namespace iRESTful\ClassesEntitiesAnnotations\Infrastructure\Factories;
use iRESTful\ClassesEntitiesAnnotations\Domain\Adapters\Factories\AnnotatedEntityAdapterFactory;
use iRESTful\ClassesEntities\Infrastructure\Factories\ConcreteEntityAdapterFactory;
use iRESTful\Annotations\Infrastructure\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteSampleAdapter;
use iRESTful\ClassesEntitiesAnnotations\Infrastructure\Adapters\ConcreteAnnotatedEntityAdapter;

final class ConcreteAnnotatedEntityAdapterFactory implements AnnotatedEntityAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $entityAdapterFactory = new ConcreteEntityAdapterFactory($this->baseNamespace);
        $entityAdapter = $entityAdapterFactory->create();

        $annotationAdapterFactory = new ConcreteAnnotationAdapterFactory($this->baseNamespace);
        $annotationAdapter = $annotationAdapterFactory->create();

        $sampleAdapter = new ConcreteSampleAdapter();

        return new ConcreteAnnotatedEntityAdapter($sampleAdapter, $entityAdapter, $annotationAdapter);
    }

}
