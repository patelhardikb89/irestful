<?php
namespace iRESTful\ClassesObjects\Infrastructure\Adapters;
use iRESTful\ClassesObjects\Domain\Adapters\ObjectAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\ClassesObjects\Infrastructure\Objects\ConcreteObject;

final class ConcreteObjectAdapter implements ObjectAdapter {
    private $namespaceAdapter;
    private $interfaceAdapter;
    private $constructorAdapter;
    private $customMethodAdapter;
    public function __construct(
        ClassNamespaceAdapter $namespaceAdapter,
        InterfaceAdapter $interfaceAdapter,
        ConstructorAdapter $constructorAdapter,
        CustomMethodAdapter $customMethodAdapter
    ) {
        $this->namespaceAdapter = $namespaceAdapter;
        $this->interfaceAdapter = $interfaceAdapter;
        $this->constructorAdapter = $constructorAdapter;
        $this->customMethodAdapter = $customMethodAdapter;
    }

    public function fromDSLObjectsToObjects(array $objects) {
        $output = [];
        foreach($objects as $oneDSLObject) {
            $object = $this->fromDSLObjectToObject($oneDSLObject);
            if (!empty($object)) {
                $output[] = $oneDSLObject;
            }
        }

        return $output;
    }

    public function fromDSLObjectToObject(Object $object) {

        if ($object->hasDatabase()) {
            return null;
        }

        $namespace = $this->namespaceAdapter->fromObjectToNamespace($object);
        $interface = $this->interfaceAdapter->fromObjectToInterface($object);
        $constructor = $this->constructorAdapter->fromObjectToConstructor($object);
        $customMethods = $this->customMethodAdapter->fromObjectToCustomMethods($object);

        return new ConcreteObject(
            $object,
            $namespace,
            $interface,
            $constructor,
            $customMethods
        );
    }

}
