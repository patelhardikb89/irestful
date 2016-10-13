<?php
namespace iRESTful\ClassesConverters\Infrastructure\Adapters;
use iRESTful\ClassesConverters\Domain\Adapters\ConverterAdapter;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\ClassesConverters\Infrastructure\Objects\ConcreteConverter;
use iRESTful\ClassesConverters\Domain\Exceptions\ConverterException;
use iRESTful\ClassesConverters\Domain\Methods\Adapters\MethodAdapter;

final class ConcreteConverterAdapter implements ConverterAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $methodAdapter;
    public function __construct(
        ClassNamespaceAdapter $namespaceAdapter,
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

        return new ConcreteConverter($data['type'], $interface, $namespace, $constructor, $methods);
    }

}
