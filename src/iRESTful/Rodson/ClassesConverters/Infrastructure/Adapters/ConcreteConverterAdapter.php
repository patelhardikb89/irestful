<?php
namespace iRESTful\Rodson\ClassesConverters\Infrastructure\Adapters;
use iRESTful\Rodson\ClassesConverters\Domain\Adapters\ConverterAdapter;
use iRESTful\Rodson\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Rodson\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\ClassesConverters\Infrastructure\Objects\ConcreteConverter;
use iRESTful\Rodson\ClassesConverters\Domain\Exceptions\ConverterException;
use iRESTful\Rodson\ClassesConverters\Domain\Methods\Adapters\MethodAdapter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Rodson\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;

final class ConcreteConverterAdapter implements ConverterAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $methodAdapter;
    private $customMethodAdapter;
    public function __construct(
        ClassNamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        MethodAdapter $methodAdapter,
        CustomMethodAdapter $customMethodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->methodAdapter = $methodAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
    }

    public function fromDataToConverter(array $data) {

        $getMethods = function(Object $object) {

            if (!$object->hasConverters()) {
                return [];
            }

            $output = [];
            $converters = $object->getConverters();
            foreach($converters as $oneConverter) {

                if (!$oneConverter->hasMethod()) {
                    continue;
                }

                $output[] = $oneConverter->getMethod();
            }

            return $output;

        };

        if (!isset($data['namespace'])) {
            throw new ConverterException('The namespace keyname is mandatory in order to convert data to a Converter object.');
        }

        if (isset($data['type'])) {
            $namespace = $this->namespaceAdapter->fromTypeToAdapterNamespace($data['type']);
            $interface = $this->interfaceAdapter->fromTypeToAdapterInterface($data['type']);
            $constructor = $this->constructorAdapter->fromTypeToAdapterConstructor($data['type']);
            $methods = $this->methodAdapter->fromDataToMethods([
                'type' => $data['type'],
                'namespace' => $data['namespace']
            ]);

            return new ConcreteConverter($interface, $namespace, $constructor, $data['type'], null, $methods);
        }

        if (isset($data['object'])) {
            $namespace = $this->namespaceAdapter->fromObjectToAdapterNamespace($data['object']);
            $interface = $this->interfaceAdapter->fromObjectToAdapterInterface($data['object']);
            $constructor = $this->constructorAdapter->fromObjectToAdapterConstructor($data['object']);

            $methods = $getMethods($data['object']);
            $customMethods = $this->customMethodAdapter->fromMethodsToCustomMethods($methods);

            return new ConcreteConverter($interface, $namespace, $constructor, null, $data['object'], null, $customMethods);
        }

        throw new ConverterException('The type or object keyname is mandatory in order to convert data to a Converter object.');
    }

}
