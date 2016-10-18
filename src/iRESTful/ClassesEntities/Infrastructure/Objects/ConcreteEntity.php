<?php
namespace iRESTful\ClassesEntities\Infrastructure\Objects;
use iRESTful\ClassesEntities\Domain\Entity;
use iRESTful\DSLs\Domain\Projects\Objects\Object;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Classes\Domain\Constructors\Constructor;
use iRESTful\ClassesEntities\Domain\Exceptions\EntityException;
use iRESTful\Classes\Domain\CustomMethods\CustomMethod;

final class ConcreteEntity implements Entity {
    private $object;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethods;
    public function __construct(
        Object $object,
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

        $this->object = $object;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->customMethods = $customMethods;
    }

    public function getObject() {
        return $this->object;
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
