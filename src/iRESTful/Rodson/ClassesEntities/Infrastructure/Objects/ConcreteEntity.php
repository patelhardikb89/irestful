<?php
namespace iRESTful\Rodson\ClassesEntities\Infrastructure\Objects;
use iRESTful\Rodson\ClassesEntities\Domain\Entity;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Entities\Entity as DSLEntity;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\ClassesEntities\Domain\Exceptions\EntityException;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;

final class ConcreteEntity implements Entity {
    private $entity;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethods;
    public function __construct(
        DSLEntity $entity,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor,
        array $customMethods = null
    ) {

        if (empty($customMethods)) {
            $customMethods = null;
        }

        if (!empty($customMethods)) {
            foreach($customMethods as $oneCustomMethod) {
                if (!($oneCustomMethod instanceof CustomMethod)) {
                    throw new EntityException('The customMethods array must only contain CustomMethod objects if non-empty.');
                }
            }
        }

        $this->entity = $entity;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->customMethods = $customMethods;
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

    public function hasCustomMethods() {
        return !empty($this->customMethods);
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

}
