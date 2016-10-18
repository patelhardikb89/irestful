<?php
namespace iRESTful\Classes\Infrastructure\Factories;
use iRESTful\Classes\Domain\CustomMethods\Adapters\Factories\CustomMethodAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;

final class ConcreteCustomMethodAdapterFactory implements CustomMethodAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $interfaceNamespaceAdapterFactory = new ConcreteInterfaceNamespaceAdapterFactory($this->baseNamespace);
        $interfaceNamespaceAdapter = $interfaceNamespaceAdapterFactory->create();

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        return new ConcreteCustomMethodAdapter($interfaceMethodParameterAdapter, $sourceCodeAdapter);
    }

}
