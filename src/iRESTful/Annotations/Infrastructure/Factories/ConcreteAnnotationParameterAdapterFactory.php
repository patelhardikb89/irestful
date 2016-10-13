<?php
namespace iRESTful\Annotations\Infrastructure\Factories;
use iRESTful\Annotations\Domain\Parameters\Adapters\Factories\ParameterAdapterFactory;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterAdapter;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterFlowAdapter;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterConverterAdapter;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterTypeAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterConverterSingleAdapter;
use iRESTful\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterFlowMethodChainAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;

final class ConcreteAnnotationParameterAdapterFactory implements ParameterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $namespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

        $annotationParameterFlowMethodChainAdapter = new ConcreteAnnotationParameterFlowMethodChainAdapter();
        $annotationParameterSingleConverterAdapter = new ConcreteAnnotationParameterConverterSingleAdapter($namespaceAdapter);
        $databaseTypeAdapter = new ConcreteDatabaseTypeAdapter(
            new ConcreteDatabaseTypeBinaryAdapter(),
            new ConcreteDatabaseTypeFloatAdapter(),
            new ConcreteDatabaseTypeIntegerAdapter(),
            new ConcreteDatabaseTypeStringAdapter()
        );

        $annotationParameterFlowAdapter = new ConcreteAnnotationParameterFlowAdapter($annotationParameterFlowMethodChainAdapter);
        $annotationParameterConverterAdapter = new ConcreteAnnotationParameterConverterAdapter($annotationParameterSingleConverterAdapter);
        $annotationParameterTypeAdapter = new ConcreteAnnotationParameterTypeAdapter($databaseTypeAdapter);

        return new ConcreteAnnotationParameterAdapter($annotationParameterFlowAdapter, $annotationParameterConverterAdapter, $annotationParameterTypeAdapter);
    }

}
