<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Converter;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Methods\Method;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Exceptions\ConverterException;

final class ConcreteSpecificClassConverter implements Converter {
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

    public function getData() {

        $methods = $this->getMethods();
        array_walk($methods, function(&$element, $index) {
            $element = $element->getData();
        });

        return [
            'interface' => $this->interface->getData(),
            'namespace' => $this->namespace->getData(),
            'constructor' => $this->constructor->getData(),
            'methods' => $methods
        ];
    }

}
