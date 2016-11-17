<?php
namespace iRESTful\Rodson\ClassesControllers\Infrastructure\Objects;
use iRESTful\Rodson\ClassesControllers\Domain\Controller;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\ClassesControllers\Domain\Exceptions\ControllerException;

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
