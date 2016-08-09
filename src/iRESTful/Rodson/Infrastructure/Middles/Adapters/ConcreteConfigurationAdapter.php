<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Configurations\Adapters\ConfigurationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteConfiguration;
use iRESTful\Rodson\Domain\Middles\Namespaces\Factories\NamespaceFactory;

final class ConcreteConfigurationAdapter implements ConfigurationAdapter {
    private $namespaceFactory;
    private $delimiter;
    private $timezone;
    public function __construct(NamespaceFactory $namespaceFactory, $delimiter, $timezone) {
        $this->namespaceFactory = $namespaceFactory;
        $this->delimiter = $delimiter;
        $this->timezone = $timezone;
    }

    public function fromAnnotatedClassesToConfiguration(array $annotatedClasses) {
        $namespace = $this->namespaceFactory->create();
        $containerClassMapper = $this->fromAnnotatedClassesToContainerClassMapper($annotatedClasses);
        $interfaceClassMapper = $this->fromAnnotatedClassesToInterfaceClassMapper($annotatedClasses);
        $adapterInterfaceClassMapper = $this->fromAnnotatedClassesToAdapterInterfaceClassMapper($annotatedClasses);

        return new ConcreteConfiguration(
            $namespace,
            $this->delimiter,
            $this->timezone,
            $containerClassMapper,
            $interfaceClassMapper,
            $adapterInterfaceClassMapper
        );
    }

    private function fromAnnotatedClassesToAdapterInterfaceClassMapper(array $annotatedClasses) {
        $output = [];
        foreach($annotatedClasses as $oneAnnotatedClass) {
            $class = $oneAnnotatedClass->getClass();
            if (!$class->hasSubClasses()) {
                continue;
            }

            $subClasses = $class->getSubClasses();
            foreach($subClasses as $oneSubClass) {
                $interfaceName = $oneSubClass->getInterface()->getNamespace()->getAllAsString();
                $output[$interfaceName] = $oneSubClass->getNamespace()->getAllAsString();
            }

        }

        return $output;
    }

    private function fromAnnotatedClassesToInterfaceClassMapper(array $annotatedClasses) {
        $output = [];
        foreach($annotatedClasses as $oneAnnotatedClass) {
            $class = $oneAnnotatedClass->getClass();
            $interface = $class->getInterface();
            
            $interfaceName = $interface->getNamespace()->getAllAsString();
            $output[$interfaceName] = $class->getNamespace()->getAllAsString();

        }

        return $output;

    }

    private function fromAnnotatedClassesToContainerClassMapper(array $annotatedClasses) {
        $output = [];
        foreach($annotatedClasses as $oneAnnotatedClass) {

            if (!$oneAnnotatedClass->hasAnnotation()) {
                continue;
            }

            $annotation = $oneAnnotatedClass->getAnnotation();
            if (!$annotation->hasContainerName()) {
                continue;
            }

            $containerName = $annotation->getContainerName();
            $output[$containerName] = $oneAnnotatedClass->getClass()->getNamespace()->getAllAsString();

        }

        return $output;

    }

}
