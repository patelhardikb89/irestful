<?php
namespace iRESTful\Rodson\ClassesConverters\Infrastructure\Objects;
use iRESTful\Rodson\ClassesConverters\Domain\Converter;
use iRESTful\Rodson\DSLs\Domain\Projects\Types\Type;
use iRESTful\Rodson\Classes\Domain\Interfaces\ClassInterface;
use iRESTful\Rodson\Classes\Domain\Namespaces\ClassNamespace;
use iRESTful\Rodson\Classes\Domain\Constructors\Constructor;
use iRESTful\Rodson\ClassesConverters\Domain\Methods\Method;
use iRESTful\Rodson\ClassesConverters\Domain\Exceptions\ConverterException;

final class ConcreteConverter implements Converter {
    private $type;
    private $interface;
    private $namespace;
    private $constructor;
    private $methods;
    public function __construct(
        Type $type,
        ClassInterface $interface,
        ClassNamespace $namespace,
        Constructor $constructor,
        array $methods
    ) {

        if (empty($methods)) {
            throw new ConverterException('The methods array cannot be empty.');
        }

        foreach($methods as $oneMethod) {
            if (!($oneMethod instanceof Method)) {
                throw new ConverterException('The methods array must only contain Method objects.');
            }
        }

        $this->type = $type;
        $this->interface = $interface;
        $this->namespace = $namespace;
        $this->constructor = $constructor;
        $this->methods = $methods;

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

    public function getMethods() {
        return $this->methods;
    }

}
