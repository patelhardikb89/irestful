<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\ObjectClass;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Exceptions\ClassException;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Inputs\Input;

final class ConcreteClass implements ObjectClass {
    private $name;
    private $input;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethods;
    private $subClasses;
    public function __construct(
        $name,
        Input $input,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor,
        array $customMethods = null,
        array $subClasses = null
    ) {

        if (empty($subClasses)) {
            $subClasses = null;
        }

        if (empty($customMethods)) {
            $customMethods = null;
        }

        if (empty($name) || !is_string($name)) {
            throw new ClassException('The name must be a non-empty string.');
        }

        if (!empty($customMethods)) {
            foreach($customMethods as $oneMethod) {

                if (!($oneMethod instanceof CustomMethod)) {
                    throw new ClassException('The customMethods array must only contain CustomMethod objects.');
                }

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
        $this->input = $input;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->customMethods = $customMethods;
        $this->subClasses = $subClasses;
    }

    public function getName() {
        return $this->name;
    }

    public function getInput() {
        return $this->input;
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

    public function hasSubClasses() {
        return !empty($this->subClasses);
    }

    public function getSubClasses() {
        return $this->subClasses;
    }

}
