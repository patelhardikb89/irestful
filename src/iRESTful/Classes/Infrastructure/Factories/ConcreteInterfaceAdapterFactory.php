<?php
namespace iRESTful\Classes\Infrastructure\Factories;
use iRESTful\Classes\Domain\Interfaces\Adapters\Factories\InterfaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;

final class ConcreteInterfaceAdapterFactory implements InterfaceAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $interfaceNamespaceAdapterFactory = new ConcreteInterfaceNamespaceAdapterFactory($this->baseNamespace);
        $interfaceNamespaceAdapter = $interfaceNamespaceAdapterFactory->create();

        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        return new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);
    }

}
