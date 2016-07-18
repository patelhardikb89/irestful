<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Outputs\Interfaces\ObjectInterface;
use iRESTful\Rodson\Domain\Outputs\Classes\Methods\Method;
use iRESTful\Rodson\Domain\Outputs\Classes\Exceptions\ClassException;
use iRESTful\Rodson\Domain\Outputs\Namespaces\ObjectNamespace;

final class ConcreteClass implements ObjectClass {
    private $name;
    private $namespace;
    private $interface;
    private $constructor;
    private $methods;
    private $properties;
    private $isEntity;
    private $subClasses;
    public function __construct(
        $name,
        ObjectNamespace $namespace,
        ObjectInterface $interface,
        Method $constructor,
        array $methods,
        array $properties,
        $isEntity,
        array $subClasses = null
    ) {

        if (empty($subClasses)) {
            $subClasses = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new ClassException('The name must be a non-empty string.');
        }

        foreach($methods as $oneMethod) {

            if (!($oneMethod instanceof Method)) {
                throw new ClassException('The methods array must only contain Method objects.');
            }

        }

        foreach($properties as $oneProperty) {

            if (!($oneProperty instanceof \iRESTful\Rodson\Domain\Outputs\Classes\Properties\Property)) {
                throw new ClassException('The properties array must only contain Property objects.');
            }

        }

        if (!empty($subClasses)) {
            foreach($subClasses as $oneSubClass) {
                if (!($oneSubClass instanceof ObjectClass)) {
                    throw new ClassException('The subClasses array must only contain Class objects.');
                }
            }
        }

        $this->name = $name;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->methods = $methods;
        $this->properties = $properties;
        $this->isEntity = (bool) $isEntity;
        $this->subClasses = $subClasses;
    }

    public function getName() {
        return $this->name;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function getInterface() {
        return $this->interface;
    }

    public function getConstructor() {
        return $this->constructor;
    }

    public function getMethods() {
        return $this->methods;
    }

    public function isEntity() {
        return $this->isEntity;
    }

    public function hasSubClasses() {
        return !empty($this->subClasses);
    }

    public function getSubClasses() {
        return $this->subClasses;
    }

}
