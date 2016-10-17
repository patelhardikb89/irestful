<?php
namespace iRESTful\Classes\Infrastructure\Objects;
use iRESTful\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Classes\Domain\Interfaces\Methods\Method;
use iRESTful\Classes\Domain\Interfaces\Exceptions\InterfaceException;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;

final class ConcreteInterface implements ClassInterface {
    private $methods;
    private $namespace;
    private $isEntity;
    public function __construct(array $methods, ClassNamespace $namespace, $isEntity) {

        if (empty($methods)) {
            throw new InterfaceException('The methods array cannot be empty.');
        }

        foreach($methods as $oneMethod) {

            if (!($oneMethod instanceof Method)) {
                throw new InterfaceException('The methods array must only contain Method objects.');
            }

        }

        $this->methods = $methods;
        $this->namespace = $namespace;
        $this->isEntity = (bool) $isEntity;
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
