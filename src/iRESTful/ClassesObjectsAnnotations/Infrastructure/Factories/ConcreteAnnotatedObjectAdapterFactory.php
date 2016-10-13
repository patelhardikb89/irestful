<?php
namespace iRESTful\ClassesObjectsAnnotations\Infrastructure\Factories;
use iRESTful\ClassesObjectsAnnotations\Domain\Adapters\Factories\AnnotatedObjectAdapterFactory;
use iRESTful\ClassesObjectsAnnotations\Infrastructure\Adapters\ConcreteAnnotatedObjectAdapter;
use iRESTful\ClassesObjects\Infrastructure\Factories\ConcreteObjectAdapterFactory;
use iRESTful\Annotations\Infrastructure\Factories\ConcreteAnnotationParameterAdapterFactory;

final class ConcreteAnnotatedObjectAdapterFactory implements AnnotatedObjectAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $objectAdapterFactory = new ConcreteObjectAdapterFactory($this->baseNamespace);
        $objectAdapter = $objectAdapterFactory->create();

        $annotationParameterAdapterFactory = new ConcreteAnnotationParameterAdapterFactory($this->baseNamespace);
        $annotationParameterAdapter = $annotationParameterAdapterFactory->create();

        return new ConcreteAnnotatedObjectAdapter($objectAdapter, $annotationParameterAdapter);
    }

}
