<?php
namespace iRESTful\Rodson\ClassesObjectsAnnotations\Infrastructure\Factories;
use iRESTful\Rodson\ClassesObjectsAnnotations\Domain\Adapters\Factories\AnnotatedObjectAdapterFactory;
use iRESTful\Rodson\ClassesObjectsAnnotations\Infrastructure\Adapters\ConcreteAnnotatedObjectAdapter;
use iRESTful\Rodson\ClassesObjects\Infrastructure\Factories\ConcreteObjectAdapterFactory;
use iRESTful\Rodson\Annotations\Infrastructure\Factories\ConcreteAnnotationParameterAdapterFactory;

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
