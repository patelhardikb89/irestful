<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Adapters\ValueAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters\Adapters\AdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassValue;

final class ConcreteSpecificClassValueAdapter implements ValueAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $customMethodAdapter;
    private $adapterAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        CustomMethodAdapter $customMethodAdapter,
        AdapterAdapter $adapterAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->adapterAdapter = $adapterAdapter;
    }

    public function fromTypesToValues(array $types) {
        $output = [];
        foreach($types as $oneType) {
            $output[] = $this->fromTypeToValue($oneType);
        }

        return $output;
    }

    public function fromTypeToValue(Type $type) {
        $adapter = $this->adapterAdapter->fromTypeToAdapter($type);
        $namespace = $this->namespaceAdapter->fromTypeToNamespace($type);
        $interface = $this->interfaceAdapter->fromTypeToInterface($type);
        $constructor = $this->constructorAdapter->fromTypeToConstructor($type);
        $customMethod = $this->customMethodAdapter->fromTypeToCustomMethod($type);

        return new ConcreteSpecificClassValue($type, $adapter, $namespace, $interface, $constructor, $customMethod);
    }

}
