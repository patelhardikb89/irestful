<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Entity;
use iRESTful\Rodson\Domain\Inputs\Objects\Object;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Entities\Exceptions\EntityException;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;

final class ConcreteSpecificClassEntity implements Entity {
    private $object;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethods;
    public function __construct(
        Object $object,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor,
        array $customMethods = null
    ) {

        if (empty($customMethods)) {
            $customMethods = null;
        }

        if (!empty($customMethods)) {
            foreach($customMethods as $oneCustomMethod) {
                if (!($oneCustomMethod instanceof CustomMethod)) {
                    throw new EntityException('The customMethods array must only contain CustomMethod objects if non-empty.');
                }
            }
        }

        $this->object = $object;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->customMethods = $customMethods;
    }

    public function getObject() {
        return $this->object;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getInterface() {
        return $this->interface;
    }

    public function getConstructor() {
        return $this->constructor;
    }

    public function hasCustomMethods() {
        return !empty($this->customMethods);
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

    public function getData() {
        $output = [
            'namespace' => $this->namespace->getData(),
            'interface' => $this->interface->getData(),
            'constructor' => $this->constructor->getData()
        ];

        if ($this->hasCustomMethods()) {
            $customMethods = $this->getCustomMethods();
            array_walk($customMethods, function(&$element, $index) {
                $element = $element->getData();
            });

            $output['custom_methods'] = $customMethods;
        }

        return $output;
    }

}