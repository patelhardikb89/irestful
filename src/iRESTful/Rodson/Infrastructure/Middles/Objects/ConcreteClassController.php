<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Controllers\Exceptions\ControllerException;

final class ConcreteClassController implements Controller {
    private $name;
    private $namespace;
    private $constructor;
    private $customMethod;
    public function __construct($name, ClassNamespace $namespace, Constructor $constructor, CustomMethod $customMethod) {

        if (empty($name) || !is_string($name)) {
            throw new ControllerException('The name must be a non-empty string.');
        }

        $this->name = $name;
        $this->namespace = $namespace;
        $this->constructor = $constructor;
        $this->customMethod = $customMethod;

    }

    public function getName() {
        return $this->name;
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
