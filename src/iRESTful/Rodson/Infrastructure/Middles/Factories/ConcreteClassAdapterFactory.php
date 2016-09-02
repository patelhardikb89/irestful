<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Classes\Adapters\Factories\ClassAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInputAdapter;

final class ConcreteClassAdapterFactory implements ClassAdapterFactory {
    private $baseNamespace;
    public function __construct(array $baseNamespace) {
        $this->baseNamespace = $baseNamespace;
    }

    public function create() {
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($this->baseNamespace);

        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classCustomMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        $interfaceMethodAdapter = new ConcreteClassInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteClassInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        $classInputAdapter = new ConcreteClassInputAdapter();

        return new ConcreteClassAdapter(
            $classNamespaceAdapter,
            $interfaceAdapter,
            $constructorAdapter,
            $classCustomMethodAdapter,
            $classInputAdapter
        );
    }

}
