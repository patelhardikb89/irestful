<?php
namespace iRESTful\ClassesConfigurations\Infrastructure\Adapters;
use iRESTful\ClassesConfigurations\Domain\Adapters\ConfigurationAdapter;
use iRESTful\ClassesConfigurations\Domain\Objects\Adapters\ObjectConfigurationAdapter;
use iRESTful\ClassesConfigurations\Domain\Exceptions\ConfigurationException;
use iRESTful\Classes\Domain\Namespaces\Factories\NamespaceFactory;
use iRESTful\ClassesConfigurations\Infrastructure\Objects\ConcreteConfiguration;
use iRESTful\ClassesConfigurations\Domain\Controllers\Nodes\Adapters\ControllerNodeAdapter;

final class ConcreteConfigurationAdapter implements ConfigurationAdapter {
    private $namespaceFactory;
    private $objectConfigurationAdapter;
    private $controllerAdapter;
    private $controllerNodeAdapter;
    public function __construct(
        NamespaceFactory $namespaceFactory,
        ObjectConfigurationAdapter $objectConfigurationAdapter,
        ControllerNodeAdapter $controllerNodeAdapter
    ) {
        $this->namespaceFactory = $namespaceFactory;
        $this->objectConfigurationAdapter = $objectConfigurationAdapter;
        $this->controllerNodeAdapter = $controllerNodeAdapter;
    }

    public function fromDataToConfiguration(array $data) {

        $getDatabasesFromAnnotatedEntities = function(array $annotatedEntities) {

            $databases = [];
            foreach($annotatedEntities as $oneAnnotatedEntity) {
                $object = $oneAnnotatedEntity->getEntity()->getObject();
                if (!$object->hasDatabase()) {
                    throw new ConfigurationException('The given AnnotatedEntity does not have a Database object.');
                }

                $database = $object->getDatabase();
                $name = $database->getName();
                if (!isset($databases[$name])) {
                    $databases[$name] = $database;
                }
            }

            return array_values($databases);

        };

        if (!isset($data['annotated_entities'])) {
            throw new ConfigurationException('The annotated_entities keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['annotated_objects'])) {
            throw new ConfigurationException('The annotated_objects keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['values'])) {
            throw new ConfigurationException('The values keyname is mandatory in order to convert data to a Configuration object.');
        }

        if (!isset($data['controllers'])) {
            throw new ConfigurationException('The controllers keyname is mandatory in order to convert data to a Configuration object.');
        }

        $databases = $getDatabasesFromAnnotatedEntities($data['annotated_entities']);
        $namespace = $this->namespaceFactory->create();
        $objectConfiguration = $this->objectConfigurationAdapter->fromDataToObjectConfiguration([
            'annotated_entities' => $data['annotated_entities'],
            'annotated_objects' => $data['annotated_objects'],
            'values' => $data['values']
        ]);

        $controllerNode = $this->controllerNodeAdapter->fromDataToControllerNode($data['controllers']);
        return new ConcreteConfiguration($namespace, $objectConfiguration, $controllerNode, $databases);

    }

}
