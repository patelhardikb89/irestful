<?php
namespace iRESTful\ClassesObjects\Infrastructure\Objects;
use iRESTful\ClassesObjects\Domain\Object;
use iRESTful\DSLs\Domain\Projects\Objects\Object as InputObject;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Classes\Domain\Constructors\Constructor;
use iRESTful\Classes\Domain\Methods\Customs\CustomMethod;
use iRESTful\ClassesObjects\Domain\Exceptions\ObjectException;

final class ConcreteObject implements Object {
    private $object;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethods;
    public function __construct(
        InputObject $object,
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
                    throw new ObjectException('The customMethods array must only contain CustomMethod objects.');
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
