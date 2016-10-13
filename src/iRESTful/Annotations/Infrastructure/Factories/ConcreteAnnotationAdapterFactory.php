<?php
namespace iRESTful\Annotations\Infrastructure\Factories;
use iRESTful\Annotations\Domain\Adapters\Factories\AnnotationAdapterFactory;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationAdapter;
use iRESTful\Annotations\Infrastructure\Factories\ConcreteAnnotationParameterAdapterFactory;

final class ConcreteAnnotationAdapterFactory implements AnnotationAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $annotationParameterAdapterFactory = new ConcreteAnnotationParameterAdapterFactory($this->baseNamespace);
        $annotationParameterAdapter = $annotationParameterAdapterFactory->create();

        return new ConcreteAnnotationAdapter($annotationParameterAdapter);
    }

}
