<?php
namespace iRESTful\Rodson\ClassesEntities\Infrastructure\Objects;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity as DSLEntity;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\ClassesEntities\Domain\Exceptions\EntityException;

final class ConcreteEntity implements Entity {
    private $entity;
    private $namespace;
    private $interface;
    private $constructor;
    public function __construct(
        DSLEntity $entity,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor
    ) {
        $this->entity = $entity;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getInterface() {
        return $this->interface;
    }

    public function getConstructor() {
        return $this->constructor;
    }

}
