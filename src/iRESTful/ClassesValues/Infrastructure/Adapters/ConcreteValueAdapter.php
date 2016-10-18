<?php
namespace iRESTful\ClassesValues\Infrastructure\Adapters;
use iRESTful\ClassesValues\Domain\Adapters\ValueAdapter;
use iRESTful\DSLs\Domain\Projects\Types\Type;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\ClassesConverters\Domain\Adapters\ConverterAdapter;
use iRESTful\ClassesValues\Infrastructure\Objects\ConcreteValue;

final class ConcreteValueAdapter implements ValueAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $customMethodAdapter;
    private $converterAdapter;
    public function __construct(
        ClassNamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        CustomMethodAdapter $customMethodAdapter,
        ConverterAdapter $converterAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
        $this->converterAdapter = $converterAdapter;
    }

    public function fromTypesToValues(array $types) {
        $output = [];
        foreach($types as $oneType) {
            $output[] = $this->fromTypeToValue($oneType);
        }

        return $output;
    }

    public function fromTypeToValue(Type $type) {
        $namespace = $this->namespaceAdapter->fromTypeToNamespace($type);
        $converter = $this->converterAdapter->fromDataToConverter([
            'type' => $type,
            'namespace' => $namespace
        ]);

        $interface = $this->interfaceAdapter->fromTypeToInterface($type);
        $constructor = $this->constructorAdapter->fromTypeToConstructor($type);
        $customMethod = $this->customMethodAdapter->fromTypeToCustomMethod($type);

        return new ConcreteValue($type, $converter, $namespace, $interface, $constructor, $customMethod);
    }

}
