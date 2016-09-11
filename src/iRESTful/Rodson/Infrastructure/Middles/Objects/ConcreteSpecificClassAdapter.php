<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters\Adapter;
use iRESTful\Rodson\Domain\Inputs\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Adapters\Exceptions\AdapterException;

final class ConcreteSpecificClassAdapter implements Adapter {
    private $type;
    private $interface;
    private $namespace;
    private $constructor;
    private $customMethods;
    public function __construct(
        Type $type,
        ClassInterface $interface,
        ClassNamespace $namespace,
        Constructor $constructor,
        array $customMethods
    ) {

        if (empty($customMethods)) {
            throw new AdapterException('The customMethods array cannot be empty.');
        }

        foreach($customMethods as $oneCustomMethod) {
            if (!($oneCustomMethod instanceof CustomMethod)) {
                throw new AdapterException('The customMethods array must only contain CustomMethod objects.');
            }
        }

        $this->type = $type;
        $this->interface = $interface;
        $this->namespace = $namespace;
        $this->constructor = $constructor;
        $this->customMethods = $customMethods;

    }

    public function getType() {
        return $this->type;
    }

    public function getInterface() {
        return $this->interface;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getConstructor() {
        return $this->constructor;
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

    public function getData() {

        $customMethods = $this->getCustomMethods();
        array_walk($customMethods, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'interface' => $this->interface->getData(),
            'namespace' => $this->namespace->getData(),
            'constructor' => $this->constructor->getData(),
            'custom_methods' => $customMethods
        ];
    }

}
