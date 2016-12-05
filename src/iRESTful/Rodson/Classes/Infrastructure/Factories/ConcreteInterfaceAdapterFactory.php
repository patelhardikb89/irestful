<?php
namespace iRESTful\Rodson\Classes\Infrastructure\Factories;
use iRESTful\Rodson\Classes\Domain\Interfaces\Adapters\Factories\InterfaceAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Factories\ConcreteInterfaceNamespaceAdapterFactory;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteCustomMethodAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\ConcreteNamespaceAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Adapters\PHPCustomMethodSourceCodeAdapter;
use iRESTful\Rodson\DSLs\Infrastructure\Adapters\ConcretePrimitiveAdapter;

final class ConcreteInterfaceAdapterFactory implements InterfaceAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {

        $primitiveAdapter = new ConcretePrimitiveAdapter();

        $interfaceNamespaceAdapterFactory = new ConcreteInterfaceNamespaceAdapterFactory($this->baseNamespace);
        $interfaceNamespaceAdapter = $interfaceNamespaceAdapterFactory->create();

        $subClassNamespaceAdapter = new ConcreteNamespaceAdapter($this->baseNamespace);

        $interfaceMethodParamaterTypeAdapter = new ConcreteInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $sourceCodeAdapter = new PHPCustomMethodSourceCodeAdapter();
        $classCustomMethodAdapter = new ConcreteCustomMethodAdapter($primitiveAdapter, $interfaceMethodParameterAdapter, $sourceCodeAdapter);

        $interfaceMethodAdapter = new ConcreteInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        return new ConcreteInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);
    }

}
