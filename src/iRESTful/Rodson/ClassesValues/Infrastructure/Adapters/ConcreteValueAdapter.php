<?php
namespace iRESTful\Rodson\ClassesValues\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesValues\Domain\Adapters\ValueAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\ClassesConverters\Domain\Adapters\ConverterAdapter;
use iRESTful\Rodson\ClassesValues\Infrastructure\Objects\ConcreteValue;

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
