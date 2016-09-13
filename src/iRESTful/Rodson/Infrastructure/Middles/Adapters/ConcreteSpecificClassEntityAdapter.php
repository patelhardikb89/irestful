<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Adapters\EntityAdapter;
use iRESTful\Rodson\Domain\Inputs\Projects\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Namespaces\Adapters\NamespaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Adapters\InterfaceAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Adapters\ConstructorAdapter;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\Adapters\CustomMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteSpecificClassEntity;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Exceptions\EntityException;

final class ConcreteSpecificClassEntityAdapter implements EntityAdapter {
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

    public function fromObjectToEntity(Object $object) {

        if (!$object->hasDatabase()) {
            throw new EntityException('The object must have a database in order to convert it to an Entity.');
        }

        $namespace = $this->namespaceAdapter->fromObjectToNamespace($object);
        $interface = $this->interfaceAdapter->fromObjectToInterface($object);
        $constructor = $this->constructorAdapter->fromObjectToConstructor($object);
        $customMethods = $this->customMethodAdapter->fromObjectToCustomMethods($object);

        return new ConcreteSpecificClassEntity(
            $object,
            $namespace,
            $interface,
            $constructor,
            $customMethods
        );
    }

}
