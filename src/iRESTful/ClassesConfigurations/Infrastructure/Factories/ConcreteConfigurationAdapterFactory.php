<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Factories;
use iRESTful\ClassesConfigurations\Domain\Adapters\Factories\ConfigurationAdapterFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Factories\ConcreteConfigurationNamespaceFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteObjectConfigurationAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Factories\ConcreteObjectConfigurationNamespaceFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerNodeAdapter;
use iRESTful\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerNodeParameterAdapter;
use iRESTful\Classes\Infrastructure\Factories\ConcreteClassNamespaceAdapterFactory;

final class ConcreteConfigurationAdapterFactory implements ConfigurationAdapterFactory {
    private $baseNamespace;
    private $dependenciesInterfaceClassMapper;
    private $delimiter;
    private $timezone;
    public function __construct(array $baseNamespace, array $dependenciesInterfaceClassMapper, $delimiter, $timezone) {
        $this->baseNamespace = $baseNamespace;
        $this->dependenciesInterfaceClassMapper = $dependenciesInterfaceClassMapper;
        $this->delimiter = $delimiter;
        $this->timezone = $timezone;
    }

    public function create() {

        $classNamespaceAdapterFactory = new ConcreteClassNamespaceAdapterFactory($this->baseNamespace);
        $classNamespaceAdapter = $classNamespaceAdapterFactory->create();

        $configurationNamespaceFactory = new ConcreteConfigurationNamespaceFactory($this->baseNamespace);

        $objectConfigurationNamespaceFactory = new ConcreteObjectConfigurationNamespaceFactory($this->baseNamespace);
        $objectConfigurationAdapter = new ConcreteObjectConfigurationAdapter($objectConfigurationNamespaceFactory, $this->delimiter, $this->timezone);

        $controllerAdapter = new ConcreteConfigurationControllerAdapter();
        $controllerNodeParameterAdapter = new ConcreteConfigurationControllerNodeParameterAdapter($classNamespaceAdapter, $this->dependenciesInterfaceClassMapper);
        $controllerNodeAdapter = new ConcreteConfigurationControllerNodeAdapter($controllerAdapter, $controllerNodeParameterAdapter);

        return new ConcreteConfigurationAdapter($configurationNamespaceFactory, $objectConfigurationAdapter, $controllerNodeAdapter);
    }

}
