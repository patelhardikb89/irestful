<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Objects;
use iRESTful\ClassesConfigurations\Domain\Objects\ObjectConfiguration;
use iRESTful\ClassesConfigurations\Domain\Exceptions\ConfigurationException;
use iRESTful\Classes\Domain\Namespaces\ClassNamespace;

final class ConcreteObjectConfiguration implements ObjectConfiguration {
    private $namespace;
    private $delimiter;
    private $timezone;
    private $containerClassMapper;
    private $interfaceClassMapper;
    private $adapterInterfaceClassMapper;
    public function __construct(
        ClassNamespace $namespace,
        $delimiter,
        $timezone,
        array $containerClassMapper,
        array $interfaceClassMapper,
        array $adapterInterfaceClassMapper
    ) {
        $this->namespace = $namespace;
        $this->delimiter = $delimiter;
        $this->timezone = $timezone;
        $this->containerClassMapper = $containerClassMapper;
        $this->interfaceClassMapper = $interfaceClassMapper;
        $this->adapterInterfaceClassMapper = $adapterInterfaceClassMapper;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    public function getDelimiter() {
        return $this->delimiter;
    }

    public function getTimezone() {
        return $this->timezone;
    }

    public function getContainerClassMapper() {
        return $this->containerClassMapper;
    }

    public function getInterfaceClassMapper() {
        return $this->interfaceClassMapper;
    }

    public function getAdapterInterfaceClassMapper() {
        return $this->adapterInterfaceClassMapper;
    }

}
