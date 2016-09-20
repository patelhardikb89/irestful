<?php
namespace iRESTful\Rodson\Infrastructure\Middles\Adapters;
use iRESTful\Rodson\Domain\Middles\Configurations\Adapters\ConfigurationAdapter;
use iRESTful\Rodson\Infrastructure\Middles\Objects\ConcreteConfiguration;
use iRESTful\Rodson\Domain\Middles\Namespaces\Factories\NamespaceFactory;
use iRESTful\Rodson\Domain\Middles\Configurations\Exceptions\ConfigurationException;

final class ConcreteConfigurationAdapter implements ConfigurationAdapter {
    private $namespaceFactory;
    private $delimiter;
    private $timezone;
    public function __construct(NamespaceFactory $namespaceFactory, $delimiter, $timezone) {
        $this->namespaceFactory = $namespaceFactory;
        $this->delimiter = $delimiter;
        $this->timezone = $timezone;
    }

    public function fromDataToConfiguration(array $data) {

        if (!isset($data['annotated_entities'])) {
            throw new ConfigurationException('The annotated_entities keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['annotated_objects'])) {
            throw new ConfigurationException('The annotated_objects keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['values'])) {
            throw new ConfigurationException('The values keyname is mandatory in order to convert data to a Configuration object.');
        }

        $namespace = $this->namespaceFactory->create();

        $entitiesInterfaceClassMapper = $this->fromAnnotatedEntitiesToInterfaceClassMapper($data['annotated_entities']);
        $objectsInterfaceClassMapper = $this->fromAnnotatedObjectsToInterfaceClassMapper($data['annotated_objects']);
        $valuesInterfaceClassMapper = $this->fromValuesToInterfaceClassMapper($data['values']);
        $interfaceClassMapper = array_merge($entitiesInterfaceClassMapper, $objectsInterfaceClassMapper, $valuesInterfaceClassMapper);

        $containerClassMapper = $this->fromAnnotatedEntitiesToContainerClassMapper($data['annotated_entities']);
        $adapterInterfaceClassMapper = $this->fromValuesToAdapterInterfaceClassMapper($data['values']);

        return new ConcreteConfiguration(
            $namespace,
            $this->delimiter,
            $this->timezone,
            $containerClassMapper,
            $interfaceClassMapper,
            $adapterInterfaceClassMapper
        );
    }

    private function fromValuesToAdapterInterfaceClassMapper(array $values) {
        $output = [];
        foreach($values as $oneValue) {
            $converter = $oneValue->getConverter();
            $interfaceName = $converter->getInterface()->getNamespace()->getAllAsString();
            $output[$interfaceName] = $converter->getNamespace()->getAllAsString();
        }

        return $output;
    }

    private function fromAnnotatedEntitiesToInterfaceClassMapper(array $annotatedEntities) {
        $output = [];
        foreach($annotatedEntities as $oneAnnotatedEntity) {
            $entity = $oneAnnotatedEntity->getEntity();
            $interfaceName = $entity->getInterface()->getNamespace()->getAllAsString();
            $output[$interfaceName] = $entity->getNamespace()->getAllAsString();
        }

        return $output;

    }

    private function fromAnnotatedObjectsToInterfaceClassMapper(array $annotatedObjects) {
        $output = [];
        foreach($annotatedObjects as $oneAnnotatedObject) {
            $object = $oneAnnotatedObject->getObject();
            $interfaceName = $object->getInterface()->getNamespace()->getAllAsString();
            $output[$interfaceName] = $object->getNamespace()->getAllAsString();
        }

        return $output;
    }

    private function fromValuesToInterfaceClassMapper(array $values) {
        $output = [];
        foreach($values as $oneValue) {
            $interfaceName = $oneValue->getInterface()->getNamespace()->getAllAsString();
            $output[$interfaceName] = $oneValue->getNamespace()->getAllAsString();
        }

        return $output;
    }

    private function fromAnnotatedEntitiesToContainerClassMapper(array $annotatedEntities) {
        $output = [];
        foreach($annotatedEntities as $annotatedEntity) {
            $containerName = $annotatedEntity->getAnnotation()->getContainerName();
            $output[$containerName] = $annotatedEntity->getEntity()->getNamespace()->getAllAsString();

        }

        return $output;

    }

}
