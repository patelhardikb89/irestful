<?php
namespace iRESTful\Rodson\Infrastructure\Objects;
use iRESTful\Rodson\Domain\Outputs\Interfaces\ObjectInterface;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Domain\Outputs\Interfaces\Namespaces\ObjectNamespace;

final class ConcreteInterface implements ObjectInterface {
    private $name;
    private $methods;
    private $namespace;
    private $subInterfaces;
    public function __construct($name, array $methods, ObjectNamespace $namespace, array $subInterfaces = null) {

        if (empty($subInterfaces)) {
            $subInterfaces = null;
        }

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

        if (!empty($subInterfaces)) {
            foreach($subInterfaces as $oneSubInterface) {

                if (!($oneSubInterface instanceof ObjectInterface)) {
                    throw new InterfaceException('The subInterfaces array must only contain ObjectInterface objects.');
                }

            }
        }

        $this->name = $name;
        $this->methods = $methods;
        $this->namespace = $namespace;
        $this->subInterfaces = $subInterfaces;
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

    public function hasSubInterfaces() {
        return !empty($this->subInterfaces);
    }

    public function getSubInterfaces() {
        return $this->subInterfaces;
    }
}
