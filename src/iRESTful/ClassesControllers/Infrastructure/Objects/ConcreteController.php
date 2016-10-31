<?php
namespace iRESTful\ClassesControllers\Infrastructure\Objects;
use iRESTful\ClassesControllers\Domain\Controller;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Classes\Domain\Constructors\Constructor;
use iRESTful\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\ClassesControllers\Domain\Exceptions\ControllerException;

final class ConcreteController implements Controller {
    private $namespace;
    private $constructor;
    private $customMethod;
    public function __construct(ClassNamespace $namespace, Constructor $constructor, CustomMethod $customMethod) {
        $this->namespace = $namespace;
        $this->constructor = $constructor;
        $this->customMethod = $customMethod;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getConstructor() {
        return $this->constructor;
    }

    public function getCustomMethod() {
        return $this->customMethod;
    }

}
