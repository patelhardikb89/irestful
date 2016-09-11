<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Controller;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Controllers\Exceptions\ControllerException;

final class ConcreteSpecificClassController implements Controller {
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

    public function getData() {
        return [
            'namespace' => $this->namespace->getData(),
            'constructor' => $this->constructor->getData(),
            'custom_method' => $this->customMethod->getData()
        ];
    }

}
