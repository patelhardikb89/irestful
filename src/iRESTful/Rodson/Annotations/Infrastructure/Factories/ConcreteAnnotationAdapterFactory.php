<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Factories;
use iRESTful\Rodson\Annotations\Domain\Adapters\Factories\AnnotationAdapterFactory;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Factories\ConcreteAnnotationParameterAdapterFactory;

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
