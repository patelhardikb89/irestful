<?php
namespace iRESTful\Rodson\ClassesConfigurations\Infrastructure\Factories;
use iRESTful\Rodson\ClassesConfigurations\Domain\Adapters\Factories\ConfigurationAdapterFactory;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationAdapter;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Factories\ConcreteConfigurationNamespaceFactory;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters\ConcreteObjectConfigurationAdapter;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Factories\ConcreteObjectConfigurationNamespaceFactory;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerAdapter;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerNodeAdapter;
use iRESTful\Rodson\ClassesConfigurations\Infrastructure\Adapters\ConcreteConfigurationControllerNodeParameterAdapter;
use iRESTful\Rodson\Classes\Infrastructure\Factories\ConcreteClassNamespaceAdapterFactory;

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
