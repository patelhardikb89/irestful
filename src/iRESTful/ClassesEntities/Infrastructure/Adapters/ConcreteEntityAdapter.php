<?php
namespace iRESTful\ClassesEntities\Infrastructure\Adapters;
use iRESTful\ClassesEntities\Domain\Adapters\EntityAdapter;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Classes\Domain\Namespaces\Adapters\ClassNamespaceAdapter;
use iRESTful\Classes\Domain\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Classes\Domain\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Classes\Domain\CustomMethods\Adapters\CustomMethodAdapter;
use iRESTful\ClassesEntities\Infrastructure\Objects\ConcreteEntity;
use iRESTful\ClassesEntities\Domain\Exceptions\EntityException;

final class ConcreteEntityAdapter implements EntityAdapter {
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

    public function fromDSLObjectsToEntities(array $objects) {
        $output = [];
        foreach($objects as $oneObject) {
            $entity = $this->fromDSLObjectToEntity($oneObject);
            if (!empty($entity)) {
                $output[] = $entity;
            }
        }

        return $output;
    }

    public function fromDSLObjectToEntity(Object $object) {

        if (!$object->hasDatabase()) {
            return null;
        }

        $namespace = $this->namespaceAdapter->fromObjectToNamespace($object);
        $interface = $this->interfaceAdapter->fromObjectToInterface($object);
        $constructor = $this->constructorAdapter->fromObjectToConstructor($object);
        $customMethods = $this->customMethodAdapter->fromObjectToCustomMethods($object);

        return new ConcreteEntity(
            $object,
            $namespace,
            $interface,
            $constructor,
            $customMethods
        );
    }

}
