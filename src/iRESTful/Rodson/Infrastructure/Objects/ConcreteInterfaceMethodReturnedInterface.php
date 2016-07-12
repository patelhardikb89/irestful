<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\ReturnedInterface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Namespaces\ObjectNamespace;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Returns\Exceptions\ReturnedInterfaceException;

final class ConcreteInterfaceMethodReturnedInterface implements ReturnedInterface {
    private $name;
    private $namespace;
    public function __construct($name, ObjectNamespace $namespace) {

        if (empty($name) || !is_string($name)) {
            throw new ReturnedInterfaceException('The name must be non-empty string.');
        }

        $this->name = $name;
        $this->namespace = $namespace;

    }

    public function getName() {
        return $this->name;
    }

    public function getNamespace() {
        return $this->namespace;
    }

}
