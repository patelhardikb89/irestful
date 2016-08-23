<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\Exceptions\InterfaceException;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;

final class ConcreteClassInterface implements ClassInterface {
    private $name;
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

    public function getData() {

        $methods = $this->getMethods();
        array_walk($methods, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'namespace' => $this->getNamespace()->getData(),
            'methods' => $methods,
            'is_entity' => $this->isEntity()
        ];
    }
}
