<?php
namespace iRESTful\Classes\Infrastructure\Factories;
use iRESTful\Classes\Domain\Methods\Customs\Adapters\Factories\CustomMethodAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;

final class ConcreteCustomMethodAdapterFactory implements CustomMethodAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $interfaceNamespaceAdapterFactory = new ConcreteInterfaceNamespaceAdapterFactory($this->baseNamespace);
        $interfaceNamespaceAdapter = $interfaceNamespaceAdapterFactory->create();

        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);
        return new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);
    }

}
