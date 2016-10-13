<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Factories;
use iRESTful\ClassesConfigurations\Domain\Adapters\Factories\ConfigurationAdapterFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Factories\ConcreteConfigurationNamespaceFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteObjectConfigurationAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Factories\ConcreteObjectConfigurationNamespaceFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerNodeAdapter;

final class ConcreteConfigurationAdapterFactory implements ConfigurationAdapterFactory {
    private $baseNamespace;
    private $delimiter;
    private $timezone;
    public function __construct(array $baseNamespace, $delimiter, $timezone) {
        $this->baseNamespace = $baseNamespace;
        $this->delimiter = $delimiter;
        $this->timezone = $timezone;
    }

    public function create() {

        $configurationNamespaceFactory = new ConcreteConfigurationNamespaceFactory($this->baseNamespace);

        $objectConfigurationNamespaceFactory = new ConcreteObjectConfigurationNamespaceFactory($this->baseNamespace);
        $objectConfigurationAdapter = new ConcreteObjectConfigurationAdapter($objectConfigurationNamespaceFactory, $this->delimiter, $this->timezone);

        $controllerAdapter = new ConcreteConfigurationControllerAdapter();
        $controllerNodeAdapter = new ConcreteConfigurationControllerNodeAdapter($controllerAdapter);

        return new ConcreteConfigurationAdapter($configurationNamespaceFactory, $objectConfigurationAdapter, $controllerNodeAdapter);
    }

}
