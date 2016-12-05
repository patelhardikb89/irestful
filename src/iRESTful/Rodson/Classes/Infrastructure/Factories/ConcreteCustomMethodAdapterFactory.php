<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Factories;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\Factories\CustomMethodAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcretePrimitiveAdapter;

final class ConcreteCustomMethodAdapterFactory implements CustomMethodAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $primitiveAdapter = new ConcretePrimitiveAdapter();

        $interfaceNamespaceAdapterFactory = new ConcreteInterfaceNamespaceAdapterFactory($this->baseNamespace);
        $interfaceNamespaceAdapter = $interfaceNamespaceAdapterFactory->create();

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        return new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);
    }

}
