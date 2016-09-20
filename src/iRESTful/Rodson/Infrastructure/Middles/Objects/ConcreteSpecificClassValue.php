<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Values\Value;
use iRESTful\Rodson\Domain\Inputs\Projects\Types\Type;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;
use iRESTful\Rodson\Domain\Middles\Classes\Interfaces\ClassInterface;
use iRESTful\Rodson\Domain\Middles\Classes\Constructors\Constructor;
use iRESTful\Rodson\Domain\Middles\Classes\Methods\Customs\CustomMethod;
use iRESTful\Rodson\Domain\Middles\Classes\Types\Converters\Converter;

final class ConcreteSpecificClassValue implements Value {
    private $type;
    private $converter;
    private $namespace;
    private $interface;
    private $constructor;
    private $customMethod;
    public function __construct(
        Type $type,
        Converter $converter,
        ClassNamespace $namespace,
        ClassInterface $interface,
        Constructor $constructor,
        CustomMethod $customMethod = null
    ) {
        $this->type = $type;
        $this->converter = $converter;
        $this->namespace = $namespace;
        $this->interface = $interface;
        $this->constructor = $constructor;
        $this->customMethod = $customMethod;
    }

    public function getType() {
        return $this->type;
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

    public function getConverter() {
        return $this->converter;
    }

    public function hasCustomMethod() {
        return !empty($this->customMethod);
    }

    public function getCustomMethod() {
        return $this->customMethod;
    }

    public function getData() {
        $output = [
            'namespace' => $this->namespace->getData(),
            'interface' => $this->interface->getData(),
            'constructor' => $this->constructor->getData(),
            'converter' => $this->converter->getData()
        ];

        if ($this->hasCustomMethod()) {
            $output['custom_method'] = $this->customMethod->getData();
        }

        return $output;
    }

}
