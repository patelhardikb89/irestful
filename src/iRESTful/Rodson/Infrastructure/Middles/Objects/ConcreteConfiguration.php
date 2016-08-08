<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Objects;
use iRESTful\Rodson\Domain\Middles\Configurations\Configuration;
use iRESTful\Rodson\Domain\Middles\Configurations\Exceptions\ConfigurationException;
use iRESTful\Rodson\Domain\Middles\Namespaces\ClassNamespace;

final class ConcreteConfiguration implements Configuration {
    private $namespace;
    private $delimiter;
    private $timezone;
    private $containerClassMapper;
    private $interfaceClassMapper;
    private $adapterInterfaceClassMapper;
    public function __construct(ClassNamespace $namespace, $delimiter, $timezone, array $containerClassMapper, array $interfaceClassMapper, array $adapterInterfaceClassMapper) {
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
