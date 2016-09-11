<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Annotations\Adapters\Factories\AnnotationAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteAnnotationParameterAdapterFactory;

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
