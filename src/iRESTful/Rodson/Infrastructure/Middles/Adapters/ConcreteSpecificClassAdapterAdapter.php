<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters\Adapters\AdapterAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassAdapter;

final class ConcreteSpecificClassAdapterAdapter implements AdapterAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $customMethodAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        CustomMethodAdapter $customMethodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
    }

    public function fromTypeToAdapter(Type $type) {
        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($type);
        $interface = $this->interfaceAdapter->fromTypeToAdapterInterface($type);
        $constructor = $this->constructorAdapter->fromTypeToAdapterConstructor($type);
        $customMethods = $this->customMethodAdapter->fromTypeToAdapterCustomMethods($type);

        return new ConcreteSpecificClassAdapter($type, $interface, $namespace, $constructor, $customMethods);
    }

}
