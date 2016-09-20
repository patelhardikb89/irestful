<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Factories;
use iRESTful\Rodson\Domain\Middles\Classes\Adapters\Factories\SpecificClassAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassNamespaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassPropertyAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassInterfaceMethodParameterTypeAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassMethodCustomAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteClassConstructorParameterMethodAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassControllerAdapterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteAnnotationAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSampleAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassEntityAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassValueAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassConverterAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassTestAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassTestTransformAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteConfigurationNamespaceFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteConfigurationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassEntityAnnotatedAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassObjectAnnotatedAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassObjectAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Factories\ConcreteAnnotationParameterAdapterFactory;
use iRESTful\Rodson\Infrastructure\Middles\Adapters\ConcreteSpecificClassConverterMethodAdapter;

final class ConcreteSpecificClassAdapterFactory implements SpecificClassAdapterFactory {
    private $baseNamespace;
    private $delimiter;
    private $timezone;
    public function __construct(
        array $baseNamespace,
        $delimiter,
        $timezone
    ) {
        $this->baseNamespace = $baseNamespace;
        $this->delimiter = $delimiter;
        $this->timezone = $timezone;
    }

    public function create() {
        $interfaceNamespaceAdapter = new ConcreteClassInterfaceNamespaceAdapter($this->baseNamespace);
        $classNamespaceAdapter = new ConcreteClassNamespaceAdapter($this->baseNamespace);

        $interfaceMethodParamaterTypeAdapter = new ConcreteClassInterfaceMethodParameterTypeAdapter();
        $interfaceMethodParameterAdapter = new ConcreteClassInterfaceMethodParameterAdapter($interfaceNamespaceAdapter, $interfaceMethodParamaterTypeAdapter);

        $classPropertyAdapter = new ConcreteClassPropertyAdapter();
        $classCustomMethodAdapter = new ConcreteClassMethodCustomAdapter($interfaceMethodParameterAdapter);

        $interfaceMethodAdapter = new ConcreteClassInterfaceMethodAdapter($classCustomMethodAdapter, $interfaceMethodParameterAdapter);
        $interfaceAdapter = new ConcreteClassInterfaceAdapter($interfaceNamespaceAdapter, $interfaceMethodAdapter);

        $classConstructorParameterMethodAdapter = new ConcreteClassConstructorParameterMethodAdapter();
        $constructorParameterAdapter = new ConcreteClassConstructorParameterAdapter($interfaceNamespaceAdapter, $classPropertyAdapter, $interfaceMethodParameterAdapter, $classConstructorParameterMethodAdapter);
        $constructorAdapter = new ConcreteClassConstructorAdapter($constructorParameterAdapter, $classCustomMethodAdapter);

        $entityAdapter = new ConcreteSpecificClassEntityAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $classCustomMethodAdapter);
        $converterMethodAdapter = new ConcreteSpecificClassConverterMethodAdapter($interfaceMethodParameterAdapter);
        $converterAdapter = new ConcreteSpecificClassConverterAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $converterMethodAdapter);
        $valueAdapter = new ConcreteSpecificClassValueAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $classCustomMethodAdapter, $converterAdapter);
        $controllerAdapterAdapter = new ConcreteSpecificClassControllerAdapterAdapter($this->baseNamespace);

        $annotationAdapterFactory = new ConcreteAnnotationAdapterFactory($this->baseNamespace);
        $annotationAdapter = $annotationAdapterFactory->create();
        $sampleAdapter = new ConcreteSampleAdapter();
        $annotatedEntityAdapter = new ConcreteSpecificClassEntityAnnotatedAdapter($sampleAdapter, $entityAdapter, $annotationAdapter);

        $objectAdapter = new ConcreteSpecificClassObjectAdapter($classNamespaceAdapter, $interfaceAdapter, $constructorAdapter, $classCustomMethodAdapter);
        $annotationParameterAdapterFactory = new ConcreteAnnotationParameterAdapterFactory($this->baseNamespace);
        $annotationParameterAdapter = $annotationParameterAdapterFactory->create();
        $annotatedObjectAdapter = new ConcreteSpecificClassObjectAnnotatedAdapter($objectAdapter, $annotationParameterAdapter);

        $configurationNamespaceFactory = new ConcreteConfigurationNamespaceFactory($this->baseNamespace);
        $configurationAdapter = new ConcreteConfigurationAdapter($configurationNamespaceFactory, $this->delimiter, $this->timezone);
        $transformAdapter = new ConcreteSpecificClassTestTransformAdapter($configurationAdapter, $this->baseNamespace);
        $testAdapter = new ConcreteSpecificClassTestAdapter($transformAdapter);

        return new ConcreteSpecificClassAdapter(
            $annotatedEntityAdapter,
            $annotatedObjectAdapter,
            $valueAdapter,
            $testAdapter,
            $controllerAdapterAdapter
        );
    }

}
