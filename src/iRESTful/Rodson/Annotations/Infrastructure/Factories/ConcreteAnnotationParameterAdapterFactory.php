<?php
namespace iRESTful\Rodson\Annotations\Infrastructure\Factories;
use iRESTful\Rodson\Annotations\Domain\Parameters\Adapters\Factories\ParameterAdapterFactory;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterFlowAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterConverterAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterTypeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterConverterSingleAdapter;
use iRESTful\Rodson\Annotations\Infrastructure\Adapters\ConcreteAnnotationParameterFlowMethodChainAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;

final class ConcreteAnnotationParameterAdapterFactory implements ParameterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $subInterfaceNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);
        $namespaceAdapter = new ConcreteInterfaceNamespaceAdapter($subInterfaceNamespaceAdapter);

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
