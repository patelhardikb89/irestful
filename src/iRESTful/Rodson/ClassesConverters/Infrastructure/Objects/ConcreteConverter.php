<?php
namespace iRESTful\Rodson\ClassesConverters\Infrastructure\Objects;
use iRESTful\Rodson\ClassesConverters\Domain\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\ClassesConverters\Domain\Methods\Method;
use iRESTful\Rodson\ClassesConverters\Domain\Exceptions\ConverterException;
use iRESTful\Rodson\Classes\Domain\CustomMethods\CustomMethod;
use iRESTful\Rodson\DSLs\Domain\Projects\Objects\Object;

final class ConcreteConverter implements Converter {
    private $type;
    private $object;
    private $interface;
    private $namespace;
    private $constructor;
    private $methods;
    private $customMethods;
    public function __construct(
        ClassInterface $interface,
        ClassNamespace $namespace,
        Constructor $constructor,
        Type $type = null,
        Object $object = null,
        array $methods = null,
        array $customMethods = null
    ) {

        if (empty($methods)) {
            $methods = null;
        }

        if (empty($customMethods)) {
            $customMethods = null;
        }

        $amount = (empty($methods) ? 0 : 1) + (empty($customMethods) ? 0 : 1);
        if ($amount != 1) {
            throw new ConverterException('There must be either methods or customMethods.  '.$amount.' given.');
        }

        $amount = (empty($type) ? 0 : 1) + (empty($object) ? 0 : 1);
        if ($amount != 1) {
            throw new ConverterException('There must be either a type or object.  '.$amount.' given.');
        }

        if (!empty($methods)) {
            foreach($methods as $oneMethod) {
                if (!($oneMethod instanceof Method)) {
                    throw new ConverterException('The methods array must only contain Method objects.');
                }
            }
        }

        if (!empty($customMethods)) {
            foreach($customMethods as $oneCustomMethod) {
                if (!($oneCustomMethod instanceof CustomMethod)) {
                    throw new ConverterException('The customMethods array must only contain CustomMethod objects.');
                }
            }
        }

        $this->type = $type;
        $this->object = $object;
        $this->interface = $interface;
        $this->namespace = $namespace;
        $this->constructor = $constructor;
        $this->methods = $methods;
        $this->customMethods = $customMethods;

    }

    public function hasType() {
        return !empty($this->type);
    }

    public function getType() {
        return $this->type;
    }

    public function hasObject() {
        return !empty($this->object);
    }

    public function getObject() {
        return $this->object;
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

    public function hasMethods() {
        return !empty($this->methods);
    }

    public function getMethods() {
        return $this->methods;
    }

    public function hasCustomMethods() {
        return !empty($this->customMethods);
    }

    public function getCustomMethods() {
        return $this->customMethods;
    }

}
