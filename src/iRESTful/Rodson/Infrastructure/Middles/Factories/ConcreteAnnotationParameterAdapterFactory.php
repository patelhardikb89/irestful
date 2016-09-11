<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Annotations\Parameters\Adapters\Factories\ParameterAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationParameterFlowAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationParameterConverterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationParameterTypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeBinaryAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeFloatAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeIntegerAdapter;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteDatabaseTypeStringAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationParameterConverterSingleAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteAnnotationParameterFlowMethodChainAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceNamespaceAdapter;

final class ConcreteAnnotationParameterAdapterFactory implements ParameterAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $namespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($this->baseNamespace);

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
