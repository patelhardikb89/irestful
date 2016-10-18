<?php
namespace iRESTful\ClassesTests\Infrastructure\Objects;
use iRESTful\ClassesTests\Domain\Controllers\Controller;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;

final class ConcreteTestController implements Controller {
    private $namespace;
    private $customMethodNodes;
    public function __construct(ClassNamespace $namespace, array $customMethodNodes) {
        $this->namespace = $namespace;
        $this->customMethodNodes = $customMethodNodes;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getCustomMethodNodes() {
        return $this->customMethodNodes;
    }

}
