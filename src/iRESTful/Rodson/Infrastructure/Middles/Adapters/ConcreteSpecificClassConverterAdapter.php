<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Adapters\ConverterAdapter;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassConverter;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Exceptions\ConverterException;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Methods\Adapters\MethodAdapter;

final class ConcreteSpecificClassConverterAdapter implements ConverterAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $methodAdapter;
    public function __construct(
        NamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        MethodAdapter $methodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->methodAdapter = $methodAdapter;
    }

    public function fromDataToConverter(array $data) {

        if (!isset($data['type'])) {
            throw new ConverterException('The type keyname is mandatory in order to convert data to a Converter object.');
        }

        if (!isset($data['namespace'])) {
            throw new ConverterException('The namespace keyname is mandatory in order to convert data to a Converter object.');
        }

        $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($data['type']);
        $interface = $this->interfaceAdapter->fromTypeToAdapterInterface($data['type']);
        $constructor = $this->constructorAdapter->fromTypeToAdapterConstructor($data['type']);
        $methods = $this->methodAdapter->fromDataToMethods([
            'type' => $data['type'],
            'namespace' => $data['namespace']
        ]);

        return new ConcreteSpecificClassConverter($data['type'], $interface, $namespace, $constructor, $methods);
    }

}
