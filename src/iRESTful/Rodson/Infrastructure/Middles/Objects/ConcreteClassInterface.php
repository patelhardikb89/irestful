<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Domain\Middles\Classes\Namespaces\ClassNamespace;

final class ConcreteClassInterface implements ClassInterface {
    private $name;
    private $methods;
    private $namespace;
    private $isEntity;
    public function __construct($name, array $methods, ClassNamespace $namespace, $isEntity) {

        if (empty($name) || !is_string($name)) {
            throw new InterfaceException('The name must be a non-empty string.');
        }

        if (empty($methods)) {
            throw new InterfaceException('The methods array cannot be empty.');
        }

        foreach($methods as $oneMethod) {

            if (!($oneMethod instanceof Method)) {
                throw new InterfaceException('The methods array must only contain Method objects.');
            }

        }

        $this->name = $name;
        $this->methods = $methods;
        $this->namespace = $namespace;
        $this->isEntity = (bool) $isEntity;
    }

    public function getName() {
        return $this->name;
    }

    public function getMethods() {
        return $this->methods;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function isEntity() {
        return $this->isEntity;
    }
}
