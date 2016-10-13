<?php
namespace iRESTful\ClassesTests\Infrastructure\Objects;
use iRESTful\ClassesTests\Domain\Controllers\Controller;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;

final class ConcreteTestController implements Controller {
    private $namespace;
    private $customMethods;
    public function __construct(ClassNamespace $namespace, array $customMethods) {
        $this->namespace = $namespace;
        $this->customMethods = $customMethods;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

}
