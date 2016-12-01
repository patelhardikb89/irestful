<?php
namespace iRESTful\Rodson\ClassesObjects\Infrastructure\Objects;
use iRESTful\Rodson\ClassesObjects\Domain\Object;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object as InputObject;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\ClassesObjects\Domain\Exceptions\ObjectException;
use iRESTful\Rodson\ClassesConverters\Domain\Converter;

final class ConcreteObject implements Object {
    private $object;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethods;
    private $converter;
    public function __construct(
        InputObject $object,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor,
        array $customMethods = null,
        Converter $converter = null
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
        $this->converter = $converter;
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

    public function hasConverter() {
        return !empty($this->converter);
    }

    public function getConverter() {
        return $this->converter;
    }

}
